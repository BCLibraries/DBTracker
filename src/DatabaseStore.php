<?php

namespace BCLib\DBTracker;

use Doctrine\Common\Cache\Cache;

class DatabaseStore
{
    /**
     * @var Cache
     */
    private $cache;
    private $api_key;
    private $site_id;

    private $cache_key;
    private $proxy_url;

    public function __construct(
        Cache $cache,
        $libguides_site_id,
        $libguides_api_key,
        $proxy_url = false,
        $list_cache_key = 'DBTRACKER_DBLIST'
    ) {
        $this->cache = $cache;
        $this->api_key = $libguides_api_key;
        $this->site_id = $libguides_site_id;
        $this->cache_key = $list_cache_key;
        $this->proxy_url = $proxy_url;
    }

    public function fetchDatabases($callback = null)
    {
        if (!$this->cache->contains($this->cache_key)) {
            $this->refresh();
        }
        $json = $this->cache->fetch($this->cache_key);

        if (isset($callback) && $callback) {
            return "$callback($json);";
        } else {
            return $json;
        }

    }

    public function refresh()
    {
        $json = file_get_contents(
            "http://lgapi.libapps.com/1.1/assets?site_id={$this->site_id}&key={$this->api_key}&asset_types=10&expand=new_trial"
        );
        $assets = json_decode($json);
        usort($assets, [$this, 'sortTrialDBsToTop']);
        $db_output_list = array_map([$this, 'buildSingleDatabaseOutput'], $assets);
        $json = json_encode($db_output_list);
        $this->cache->save($this->cache_key, $json);
    }

    private function buildSingleDatabaseOutput($input_db)
    {
        $output_db = new \stdClass();
        $output_db->short_name = $input_db->name;
        $output_db->url = $input_db->meta->enable_proxy ? $this->proxify($input_db->url) : $input_db->url;

        if (isset($input_db->enable_trial)) {
            $output_db->enable_trial = true;
        }
        return $output_db;
    }

    private function sortTrialDBsToTop($db_1, $db_2)
    {
        // If db 1 is a trial and db 2 is not, promote db 1
        if (isset($db_1->enable_trial) && $db_1->enable_trial) {
            if (!isset($db_2->enable_trial) || !$db_2->enable_trial) {
                return -1;
            }
        }

        // If db 2 is a trial and db 1 is not, promote db 2
        if (isset($db_2->enable_trial) && $db_2->enable_trial) {
            if (!isset($db_1->enable_trial) || !$db_1->enable_trial) {
                return 1;
            }
        }

        // Otherwise, sort alphabetically
        return strcasecmp($db_1->name, $db_2->name);
    }

    private function proxify($unproxied_url)
    {
        return "https://proxy.bc.edu/login?url=$unproxied_url";
    }
}
