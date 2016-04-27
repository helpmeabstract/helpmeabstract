<?php
/**
 * Created by PhpStorm.
 * User: kayladaniels
 * Date: 3/25/15
 * Time: 8:26 PM
 */

namespace Kayladnls\Entity;

use Spot\Entity;

class Proposal extends Entity
{
    protected static $mapper = 'Kayladnls\Entity\Mapper\Proposal';

    protected static $table = 'abstracts';

    public static function fields()
    {
        return [
            'id'        => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'email'     => ['type' => 'string', 'required' => true, 'unique' => true],
            'fullname'  => ['type' => 'string', 'required' => true],
            'link'      => ['type' => 'string', 'required' => true],
            'max_chars' => ['type' => 'integer', 'required' => false]
        ];
    }

    public function getHtml()
    {
        $html = "<h3>Abstract Submitted</h3>";
        $html .= "<b> Name: </b> " . $this->fullname . "<br>";
        $html .= "<b> Email: </b> " . $this->email . "<br>";
        $html .= "<b> Link: </b> <a href='" . $this->link . "' >Review Now</a><br><br><br>";
        $html .= "<b> You're receiving this email because you signed up to volunteer to review abstracts at HelpMeAbstract.com<br>";

        return $html;
    }
}
