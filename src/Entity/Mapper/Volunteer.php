<?php
/**
 * Created by PhpStorm.
 * User: kayladaniels
 * Date: 3/25/15
 * Time: 8:29 PM
 */

namespace Kayladnls\Entity\Mapper;
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
        $return = array();
        foreach ($all as $volunteer)
        {
            $volunteer->profile_image = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $volunteer->email ) ) ). "?s=150";

            $return[] = $volunteer;
        }

        return $return;

    }

    public function getForMandrill()
    {
        $all = $this->all();
        $return = array();
        foreach ($all as $v)
        {

            $return[] = array(
                'email' => $v->email,
                    'name' => $v->fullname,
                    'type' => 'bcc'
                );
        }

        return $return;

    }

    public function findByEmail($email)
    {
        return $this->where(['email' => $email])->count();
    }


    public function verifyFields()
    {
        if (!isset ($_POST['email'])  || ! !isset ($_POST['name']) )
        {
            return array('error' => 'All Fields Are Required.');
        }

        return array();

    }

}