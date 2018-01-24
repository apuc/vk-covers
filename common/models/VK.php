<?php

/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 12.05.2017
 * Time: 22:13
 */

namespace common\models;

use common\classes\Debug;

class VK
{

    public $client_id, $client_secret, $access_token;
    public $version = '5.64';

    /**
     * VK constructor.
     * @param $data array
     */
    public function __construct($data)
    {
        $this->client_id = $data['client_id'];
        $this->client_secret = $data['client_secret'];
        $this->access_token = $data['access_token'];
    }

    /**
     * @param $method string
     * @param $params array
     * @return string
     */
    public function createRequest($method, $params)
    {
        $r = 'https://api.vk.com/method/' . $method . '?';
        $paramsStr = '';
        foreach ((array)$params as $key => $param) {
            $paramsStr .= $key . '=' . $param . '&';
        }
        $r .= $paramsStr;
        $r .= 'access_token=' . $this->access_token . '&';
        $r .= 'v=' . $this->version;
        return $r;
    }

    /**
     * @param $method string
     * @param $params array
     * @return bool|string
     */
    public function request($method, $params)
    {
        $request = $this->createRequest($method, $params);
        //Debug::prn($request);
        return file_get_contents(urldecode($request));
    }

    /**
     * @param $domain
     * @param $data
     * @return bool|string
     */
    public function getGroupWall($domain, $data)
    {
        echo 'get group' . "\n";
        $data['domain'] = $domain;
        return $this->request('wall.get', $data);
    }

    public function getGroups($user_id = null, array $data = array())
    {
        if(null !== $user_id){
            $data['user_id'] = $user_id;
        }
        return $this->request('groups.get', $data);
    }

    public function getGroupInfoByDomain($domain, array $data = array())
    {
        $data['group_id'] = $domain;
        return $this->request('groups.getById', $data);
    }

    public function setPostToGroup($ownerId, $data)
    {
        $data['owner_id'] = $ownerId;
        return $this->request('wall.post', $data);
    }

    public function getProductCat($count = 100)
    {
        return $this->request('market.getCategories', ['count' => $count]);
    }

    public function getProducts($ownerId, $data)
    {
        $data['owner_id'] = $ownerId;
        return $this->request('market.get', $data);
    }

    public function getAllProducts($ownerId, $data)
    {
        $res = json_decode($this->getProducts($ownerId, $data));
        $count = $res->response->count;
        $steps = ceil($count / 100);
        $arr = [];
        for ($i = 0; $i <= $steps; $i++) {
            $res = json_decode($this->getProducts($ownerId, ['count' => 100, 'offset' => $i * 100, 'extended' => 1]));
            $arr = array_merge($arr, $res->response->items);
        }
        return $arr;
    }

    public function getOwnerCoverPhotoUploadServer($groupId, array $data = array())
    {
        $data['group_id'] = $groupId;
        return $this->request('photos.getOwnerCoverPhotoUploadServer', $data);
    }

    public function saveOwnerCoverPhoto($hash, $photo)
    {
        return $this->request('photos.saveOwnerCoverPhoto', ['hash' => $hash, 'photo' => $photo]);
    }

    public function addOwnerCoverPhoto($groupId, $photo, array $data = array())
    {
        $server = json_decode($this->getOwnerCoverPhotoUploadServer($groupId, $data));
        if (!isset($server->response->upload_url)) {
            return false;
        }
        $url = $server->response->upload_url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('photo' => new \CURLFile($photo)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
        $out = json_decode(curl_exec($ch));
        curl_close($ch);
        return json_decode($this->saveOwnerCoverPhoto($out->hash, $out->photo));
    }

    /**
     * @param $group
     * @param $postId
     * @param array $data
     * @return bool|string
     */
    public function getPostComments($group, $postId, array $data = array())
    {
        $data['owner_id'] = $group;
        $data['post_id'] = $postId;
        return $this->request('wall.getComments', $data);
    }

    /**
     * @param $group
     * @param $postId
     * @param array $data
     * @return bool|string
     */
    public function getPostLikes($group, $postId, array $data = array())
    {
        $data['owner_id'] = $group;
        $data['item_id'] = $postId;
        $data['type'] = 'post';
        return $this->request('likes.getList', $data);
    }

    public function getUsers(array $ids, array $fields)
    {
        if (!empty($ids) && !empty($fields)) {
            $data['user_ids'] = implode(',', $ids);
            $data['fields'] = implode(',', $fields);
            return $this->request('users.get', $data);
        }
    }

    public static function getPhotoFromObj($photoObj)
    {
        if (isset($photoObj->{'photo_' . $photoObj->width})) {
            return $photoObj->{'photo_' . $photoObj->width};
        }
        if (isset($photoObj->photo_1280)) {
            return $photoObj->photo_1280;
        }
        if (isset($photoObj->photo_807)) {
            return $photoObj->photo_807;
        }
        if (isset($photoObj->photo_604)) {
            return $photoObj->photo_604;
        }
    }

}