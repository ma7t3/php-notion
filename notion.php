<?php

class Notion {

    private string $token;
    private bool $success;
    private array $successMultiple;

    function __construct(string $token) {
        $this->success = false;
        $this->successMultiple = [];
        $this->token = $token;
    }

    public function successful() :bool {
        return $this->success;
    }

    public function successfulMultiple(int $requestIndex) :bool {
        return $this->successMultiple[$requestIndex];
    }

     ///////////////
    // Endpoints //
   ///////////////

    public function appendBlockChildren(string $blockID, array|object $data) :stdClass {
        return $this->sendNewRequest("PATCH", "https://api.notion.com/v1/blocks/$blockID/children", $data);
    }

    public function appendBlocksChildren(array $blockIDs, array $data) :array {
        $urls = [];
        foreach($blockIDs as $current)
            $urls[] = "https://api.notion.com/v1/blocks/$current/children";

        return $this->sendMultipleRequests("PATCH", $urls, $data);
    }

    public function getBlock(string $blockID) :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/blocks/$blockID");
    }

    public function getBlocks(array $blockIDs) :array {
        $urls = [];
        foreach($blockIDs as $current)
            $urls[] = "https://api.notion.com/v1/blocks/$current";

        return $this->sendMultipleRequests("GET", $urls);
    }

    public function getBlockChilds(string $blockID) :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/blocks/$blockID/children");
    }

    public function getBlocksChilds(array $blockIDs) :array {
        $urls = [];
        foreach($blockIDs as $current)
            $urls[] = "https://api.notion.com/v1/blocks/$current/children";

        return $this->sendMultipleRequests("GET", $urls);
    }

    public function updateBlock(string $blockID, array|object $data) :stdClass {
        return $this->sendNewRequest("PATCH", "https://api.notion.com/v1/blocks/$blockID", $data);
    }

    public function updateBlocks(array $blockIDs, array $data) :array {
        $urls = [];
        foreach($blockIDs as $current)
            $urls[] = "https://api.notion.com/v1/blocks/$current";

        return $this->sendMultipleRequests("PATCH", $urls, $data);
    }

    public function deleteBlock(string $blockID) :stdClass {
        return $this->updateBlock($blockID, ["archived" => true]);
    }

    public function deleteBLocks(array $blockIDs) :array {
        return $this->updateBlocks($blockIDs, ["archived" => true]);
    }

    public function createPage(array|object $data) :stdClass {
        return $this->sendNewRequest("POST", "https://api.notion.com/v1/pages", $data);
    }

    public function createPages(array $data) :array {
        $urls = [];
        for($i = 0; $i < count($data); $i++)
            $urls[] = "https://api.notion.com/v1/pages";

        return $this->sendMultipleRequests("POST", $urls, $data);
    }

    public function getPage(string $pageID) :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/pages/$pageID");
    }

    public function getPages(array $pageIDs) :array {
        $urls = [];
        foreach($pageIDs as $current)
            $urls[] = "https://api.notion.com/v1/pages/$current";

        return $this->sendMultipleRequests("GET", $urls);
    }

    public function getPagePropertyItem(string $pageID, string $propertyID) :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/pages/$pageID/properties/$propertyID");
    }

    public function getPagesPropertyItems(array $pageIDs, array $propertyIDs) :array {
        $urls = [];
        foreach($pageIDs as $key => $current)
            $urls[] = "https://api.notion.com/v1/pages/$current/properties/$propertyIDs[$key]";

        return $this->sendMultipleRequests("GET", $urls);
    }

    public function updatePage(string $pageID, array|object $data) :stdClass {
        return $this->sendNewRequest("PATCH", "https://api.notion.com/v1/pages/$pageID", $data);
    }

    public function updatePages(array $pageIDs, array $data) :array {
        $urls = [];
        foreach($pageIDs as $current)
            $urls[] = "https://api.notion.com/v1/pages/$current";

        return $this->sendMultipleRequests("PATCH", $urls, $data);
    }

    public function trashPage(string $pageID) :stdClass {
        return $this->updatePage($pageID, ["archived" => true]);
    }

    public function trashPages(array $pageIDs) :array {
        $data = [];
        for($i = 0; $i < count($pageIDs); $i++) {
            $data[] = ["archived" => true];
        }

        return $this->updatePages($pageIDs, $data);
    }

    public function createDatabase(array $data) :stdClass {
        return $this->sendNewRequest("POST", "https://api.notion.com/v1/databases", $data);
    }

    public function createDatabases(array $data) :array {
        $urls = [];
        for($i = 0; $i < count($data); $i++)
            $urls[] = "https://api.notion.com/v1/databases";

        return $this->sendMultipleRequests("POST", $urls, $data);
    }

    public function queryDatabase(string $databaseID, array $filter = [], array $sort = []) :stdClass {
        $body = [];
        if(!empty($filter)) {
            $body["filter"] = $filter;
        }
        if(!empty($sort)) {
            $body["sorts"] = $sort;
        }

        return $this->sendNewRequest("POST", "https://api.notion.com/v1/databases/$databaseID/query", $body);
    }

    public function getDatabase(string $databaseID) :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/databases/$databaseID");
    }

    public function getDatabases(array $databaseIDs) :array {
        $urls = [];
        foreach($databaseIDs as $current)
            $urls[] = "https://api.notion.com/v1/databases/$current";

        return $this->sendMultipleRequests("GET", $urls);
    }

    public function updateDatabase(string $databaseID, array|object $data) :stdClass {
        return $this->sendNewRequest("PATCH", "https://api.notion.com/v1/databases/$databaseID", $data);
    }

    public function updateDatabases(array $databaseIDs, array $data) :array {
        $urls = [];
        foreach($databaseIDs as $current)
            $urls[] = "https://api.notion.com/v1/databases/$current";

        return $this->sendMultipleRequests("PATCH", $urls, $data);
    }

    public function listAllUsers() :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/users");
    }

    public function getUser(string $userID) :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/users/$userID");
    }

    public function getUsers(array $userIDs) :array {
        $urls = [];
        foreach($userIDs as $current)
            $urls[] = "https://api.notion.com/v1/users/$current";

        return $this->sendMultipleRequests("GET", $urls);
    }

    public function getMyselfUser() :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/users/me");
    }

    public function createComment(array|object $data) :stdClass {
        return $this->sendNewRequest("POST", "https://api.notion.com/v1/comments", $data);
    }

    public function createComments(array $data) :array {
        $urls = [];
        for($i = 0; $i < count($data); $i++)
            $urls[] = "https://api.notion.com/v1/comments";

        return $this->sendMultipleRequests("POST", $urls, $data);
    }

    public function getComments(string $blockID) :stdClass {
        return $this->sendNewRequest("GET", "https://api.notion.com/v1/comments?block_id=$blockID");
    }

    public function searchByTitle(array|object $data) :stdClass {
        return $this->sendNewRequest("POST", "https://api.notion.com/v1/search", $data);
    }


     /////////////////////////
    // Protected functions //
   /////////////////////////
    
    protected function sendNewRequest(string $method, string $url, stdClass|array $data = []) :stdClass {
        $r = $this->generateRequest($method, $url, $data);

        $data = curl_exec($r);
        return $this->fetchRequestResults($r, $data);
    }

    protected function sendMultipleRequests(string $method, array $urls, array $data = []) :array {
        $r = curl_multi_init();
        $handles = [];

        foreach($urls as $key => $current) {
            $ch = $this->generateRequest($method, $current, !empty($data) ? $data[$key] : []);
            curl_multi_add_handle($r, $ch);
            $handles[] = $ch;
        }

        do {
            $status = curl_multi_exec($r, $active);
            if ($active)
                curl_multi_select($r);

        } while ($active && $status == CURLM_OK);

        $results = [];
        $this->successMultiple = [];
        foreach($handles as $key =>$current)
            $results[] = $this->fetchRequestResults($current, curl_multi_getcontent($current), $key);

        return $results;
    }

    protected function generateRequest(string $method, string $url, stdClass|array $data = []) :CurlHandle {
        $r = curl_init($url);
        $headers = [
            "Authorization: Bearer $this->token",
            "Content-Type: application/json",
            "Notion-Version: 2022-06-28"
        ];

        curl_setopt($r, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($r, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($r, CURLOPT_CUSTOMREQUEST, $method);

        if($method != "GET" && $method != "DELETE")
            curl_setopt($r, CURLOPT_POSTFIELDS, json_encode((object)$data));

        return $r;
    }

    protected function fetchRequestResults(CurlHandle $r, $content, int $requestIndex = -1) :object|array|null {
        $data = json_decode($content);
        $code = curl_getinfo($r, CURLINFO_HTTP_CODE);

        curl_close($r);

        if($code == 200) {
            $this->success = true;
            $this->successMultiple[] = true;
        } else {
            $this->success = false;
            $this->successMultiple[] = false;
        }

        if($data === null) {
            $data = new stdClass;
        }

        return $data;
    }
}