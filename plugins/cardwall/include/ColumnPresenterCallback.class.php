<?php

/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
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
class ColumnPresenterCallback implements TreeNodeCallback {

    
    public function apply(TreeNode $node) {
        if ($node instanceof Tracker_TreeNode_CardPresenterNode) {
            $presenter = new ColumnPresenter($node->getCardPresenter(), 0);
            return new Cardwall_ColumnPresenterNode($node, $presenter);
        }
        return clone $node;
//                    $data      = $node->getData();
//            $presenter = $node->getCardPresenter();
//            $field     = $this->getField($presenter->getArtifact());
//            $data['column_field_id'] = 0;
//            if ($field) {
//                $field_id                = $field->getId();
//                $data['column_field_id'] = $field_id;
//            }
//            $node->setData($data);

    }
}

?>
