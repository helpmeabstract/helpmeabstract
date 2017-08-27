<?php
/**
 * Created by PhpStorm.
 * User: kayladaniels
 * Date: 3/25/15
 * Time: 8:29 PM
 */

namespace HelpMeAbstract\Entity\Mapper;

use Spot\Mapper;


class Volunteer extends Mapper
{
    /**
     * Get 10 most recent posts for display on the sidebar
     *
     * @return \Spot\Query
     */
    public function getForHomePage()
    {
        $all = $this->all();
        $return = [];
        foreach ($all as $volunteer) {
            $volunteer->profile_image = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($volunteer->email))) . "?s=150";

            $return[] = $volunteer;
        }

        return $return;

    }

    public function getAllForEmail()
    {
        $volunteers = $this->all();

        $return = [];
        foreach ($volunteers as $volunteer) {
            $return[] =
                [
                    'emailAddress' => $volunteer->email,
                    'name' => $volunteer->fullname
                ];
        }

        return $return;
    }

    public function findByEmail($email)
    {
        return $this->where(['email' => $email])->count();
    }


    public function verifyFields()
    {
        return (empty($_POST['email']) && empty($_POST['email']) && empty($_POST['twitter']) && empty($_POST['github']))
            ? ['error' => 'All Fields Are Required.']
            : [];

    }

}
