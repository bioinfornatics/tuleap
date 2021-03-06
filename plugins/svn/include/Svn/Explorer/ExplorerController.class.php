<?php
/**
 * Copyright (c) Enalean, 2015 - 2017. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tuleap\Svn\Explorer;

use CSRFSynchronizerToken;
use Feedback;
use HTTPRequest;
use Project;
use SystemEventManager;
use Tuleap\Svn\Repository\Exception\CannotCreateRepositoryException;
use Tuleap\Svn\Repository\Exception\RepositoryNameIsInvalidException;
use Tuleap\Svn\Repository\Exception\UserIsNotSVNAdministratorException;
use Tuleap\Svn\Repository\Repository;
use Tuleap\Svn\Repository\RepositoryCreator;
use Tuleap\Svn\Repository\RepositoryManager;
use Tuleap\Svn\ServiceSvn;
use Tuleap\Svn\SvnPermissionManager;

class ExplorerController {
    const NAME = 'explorer';

    /** @var SvnPermissionManager */
    private $permissions_manager;

    /** @var RepositoryManager */
    private $repository_manager;

    /** @var SystemEventManager */
    private $system_event_manager;
    /**
     * @var RepositoryBuilder
     */
    private $repository_builder;
    /**
     * @var RepositoryCreator
     */
    private $repository_creator;

    public function __construct(
        RepositoryManager $repository_manager,
        SvnPermissionManager $permissions_manager,
        RepositoryBuilder $repository_builder,
        RepositoryCreator $repository_creator
    ) {
        $this->repository_manager   = $repository_manager;
        $this->permissions_manager  = $permissions_manager;
        $this->system_event_manager = SystemEventManager::instance();
        $this->repository_builder   = $repository_builder;
        $this->repository_creator   = $repository_creator;
    }

    public function index(ServiceSvn $service, HTTPRequest $request) {
        $this->renderIndex($service, $request);
    }

    private function renderIndex(ServiceSvn $service, HTTPRequest $request)
    {
        $project = $request->getProject();
        $token   = $this->generateTokenForCeateRepository($request->getProject());

        $repository_list = $this->repository_manager->getRepositoriesInProjectWithLastCommitInfo($request->getProject());
        $repositories    = $this->repository_builder->build($repository_list);
        $is_admin        = $this->permissions_manager->isAdmin($project, $request->getCurrentUser());

        $service->renderInPage(
            $request,
            'Welcome',
            'explorer/index',
            new ExplorerPresenter(
                $project,
                $token,
                $request->get('name'),
                $repositories,
                $is_admin
            )
        );
    }

    private function generateTokenForCeateRepository(Project $project) {
        return new CSRFSynchronizerToken(SVN_BASE_URL."/?group_id=".$project->getid(). '&action=createRepo');
    }

    public function createRepository(HTTPRequest $request, \PFUser $user)
    {
        $token = $this->generateTokenForCeateRepository($request->getProject());
        $token->check();

        $repo_name = $request->get("repo_name");

        $repository_to_create = new Repository("", $repo_name, "", "", $request->getProject());
        try {
            $this->repository_creator->create($repository_to_create, $user);

            $GLOBALS['Response']->addFeedback('info', $repo_name.' '.$GLOBALS['Language']->getText('plugin_svn_manage_repository', 'update_success'));
            $GLOBALS['Response']->redirect(SVN_BASE_URL.'/?'. http_build_query(array('group_id' => $request->getProject()->getid())));
        } catch (CannotCreateRepositoryException $e) {
            $GLOBALS['Response']->addFeedback(Feedback::ERROR, $repo_name.' '.$GLOBALS['Language']->getText('plugin_svn', 'update_error'));
            $GLOBALS['Response']->redirect(SVN_BASE_URL.'/?'. http_build_query(array('group_id' => $request->getProject()->getid(), 'name' =>$repo_name)));
        } catch(UserIsNotSVNAdministratorException $e) {
            $GLOBALS['Response']->addFeedback(Feedback::ERROR, dgettext('tuleap-svn', "User doesn't have permission to create a repository"));
            $GLOBALS['Response']->redirect(SVN_BASE_URL.'/?'. http_build_query(array('group_id' => $request->getProject()->getid(), 'name' =>$repo_name)));
        } catch (RepositoryNameIsInvalidException $e) {
            $GLOBALS['Response']->addFeedback(Feedback::ERROR, $GLOBALS['Language']->getText('plugin_svn_manage_repository', 'invalid_name'));
            $GLOBALS['Response']->addFeedback(Feedback::ERROR, $e->getMessage());
            $GLOBALS['Response']->redirect(SVN_BASE_URL.'/?'. http_build_query(array('group_id' => $request->getProject()->getid(), 'name' =>$repo_name)));
        }
    }
}
