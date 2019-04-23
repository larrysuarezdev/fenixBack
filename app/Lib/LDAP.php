<?php

namespace App\Lib;

use Log as Log;

class LDAP
{
    public static function authenticate($credentials)
    {
        $username = $credentials['Username'];
        $password = $credentials['Password'];
        
        if (empty($username) or empty($password)) {
            error_log('Error binding to LDAP: username or password empty');
            return false;
        }

        $ldapRdn = env('LDAP_BASE_DN');
        $server = env('LDAP_SERVER');

        try {
            $ldapconn = ldap_connect($server);
        } catch (\Exception $e) {
            error_log($server);
            error_log($e->getMessage());
            return false;
        }
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_TIMELIMIT, 10);
        ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

        $result = false;
        
        if ($ldapconn) {
            $ldapbind = @ldap_bind($ldapconn, "cn=".env('LDAP_USER').",".$ldapRdn, env('LDAP_PASSWORD'));

            if ($ldapbind) {
                $read = ldap_search($ldapconn, $ldapRdn, "(cn=".$username.")");
                $data = ldap_get_entries($ldapconn, $read);
                if ($data["count"] == 0) {
                    $result = false;
                } else {
                    $check = @ldap_bind($ldapconn, $data[0]["dn"], $password);
                    if ($check) {
                        $result = $data[0];
                    } else {
                        $result = false;
                    }
                }
                ldap_unbind($ldapconn);
            } else {
                Log::error('Error binding to LDAP server.');
            }
        } else {
            Log::error('Error connecting to LDAP.');
        }
        return $result;
    }

    public static function getLdapRdn($username)
    {
        return str_replace('[username]', $username, 'cn=[username],' . env('LDAP_TREE'));
    }
}
