<?php
/**
 * Created by PhpStorm.
 * User: kayladaniels
 * Date: 3/25/15
 * Time: 8:29 PM
 */

namespace Kayladnls\Entity\Mapper;

use Spot\Mapper;


class Proposal extends Mapper
{
    public function verifyFields()
    {
        if (empty($_POST['name']) && empty($_POST['email']) || empty($_POST['link'])) {
            return array('error' => 'All Fields Are Required.');
        }

        if (strpos($_POST['link'], 'gist.github.com') == false) {
            return array('error' => 'Unfortunately we can only accept Gist links at this');
        }

        return array();
    }
}
