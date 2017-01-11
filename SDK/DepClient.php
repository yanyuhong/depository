<?php


class DepClient
{
    public $appId = "appId";
    public $secret = "secret";
    public $url = "url";
    public $version = "v1/";

    private function getHeaders()
    {
        $headers[] = "appId: " . $this->appId;
        $headers[] = "secret: " . $this->secret;

        return $headers;
    }

    /**
     * @param $request Request
     * @return bool
     */
    public function execute($request)
    {
        if (!$request->checkParam()) {
            return false;
        }
        $url = $this->url . $this->version . $request->getMethodName() . '?' . $request->getParam();
        $headers = $this->getHeaders();
        $post = $request->getPost();
        $response = $this->curl($url, $headers, $post);
        $request->response(json_decode($response));
        return true;
    }

    /**
     * @param $url string
     * @param $headers array
     * @param null $post array
     * @return mixed
     * @throws Exception
     */
    protected function curl($url, $headers, $post = null)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if ($post && count($post) > 0) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl), 0);
        } else {
            $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($response, $httpStatusCode);
            }
        }

        curl_close($curl);
        return $response;
    }

}