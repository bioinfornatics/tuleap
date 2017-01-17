<?php
/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
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
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Tuleap\Tracker\Report\Query\Advanced\Grammar;

class BetweenValue implements Value
{
    /**
     * @var string
     */
    private $min_value;
    /**
     * @var string
     */
    private $max_value;

    public function __construct($min_value, $max_value)
    {
        $this->min_value = $min_value;
        $this->max_value = $max_value;
    }

    /**
     * @return string
     */
    public function getMinValue()
    {
        return $this->min_value;
    }

    /**
     * @return string
     */
    public function getMaxValue()
    {
        return $this->max_value;
    }
}
