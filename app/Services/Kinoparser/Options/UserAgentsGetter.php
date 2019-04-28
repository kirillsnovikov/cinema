<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Options;

use App\Contracts\Kinoparser\UserAgentsGetterInterface;
use App\Services\Kinoparser\Curl\BaseCurl;

/**
 * Description of UserAgentsGetter
 *
 * @author Кирилл
 */
class UserAgentsGetter implements UserAgentsGetterInterface
{

    /**
     * 
     * @return string
     */
    public function getUserAgents(): string
    {
        if (realpath(BaseCurl::USER_AGENTS_FILE)) {
            $user_agents = file(BaseCurl::USER_AGENTS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (!empty($user_agents)) {
                return $user_agents[mt_rand(0, count($user_agents) - 1)];
            }
        }
        return $_SERVER['HTTP_USER_AGENT'];
    }

}
