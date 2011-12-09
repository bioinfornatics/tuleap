<?php
/**
 * Copyright (c) Enalean, 2011. All Rights Reserved.
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

Mock::generate('GitViews');
Mock::generate('User');

abstract class GitViewsRepositoriesTraversalStrategyTest extends UnitTestCase {
    
    public function __construct($classname) {
        parent::__construct();
        $this->classname = $classname;
    }
    
    public function testEmptyListShouldReturnEmptyString() {
        $view = new MockGitViews();
        $user = new MockUser();
        $repositories = array();
        $strategy = new $this->classname($view);
        $this->assertIdentical('', $strategy->fetch($repositories, $user));
    }
    
    public function testFlatTreeShouldReturnRepresentation() {
        $view = new MockGitViews();
        $user = new MockUser();
        $strategy = TestHelper::getPartialMock($this->classname, array('getRepository'));
        
        $repositories    = $this->getFlatTree($strategy);
        $expectedPattern = $this->getExpectedPattern($repositories);
        
        $strategy->__construct($view);
        $this->assertPattern('`'. $expectedPattern .'`', $strategy->fetch($repositories, $user));
    }
    
    public abstract function getExpectedPattern($repositories);
    
    protected function getFlatTree($strategy) {
        //go find the variable $repositories
        include dirname(__FILE__) .'/_fixtures/flat_tree_of_repositories.php'; 
        
        foreach ($repositories as $row) {
            $r = new MockGitRepository();
            $r->setReturnValue('getId', $row['repository_id']);
            $r->setReturnValue('getDescription', $row['repository_description']);
            $r->setReturnValue('userCanRead', true);
            
            $strategy->setReturnValue('getRepository', $r, array($row));
        }
        return $repositories;
    }
}
?>
