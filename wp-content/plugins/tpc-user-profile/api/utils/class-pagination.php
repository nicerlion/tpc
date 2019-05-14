<?php

class TPC_Pagination {

    public function __construct($query, $params=array()) {
        $this->params = $this->get_params($params);
        $this->query = $this->get_query_from_array($query);
    }

    /**
     * Method to get params, this params will send to url
     * 
     * @param array $params List of params to merge with default params
     * @return array Param List
     */
    private function get_params($params) {  // Singleton
        if (!isset($this->_params)) {
            $this->_params = array_merge(array(
                'page' => '1',
                'limit' => '10'
            ), $params);
        }
        return $this->_params;
    }

    /**
     * Method to set params
     * 
     * @param array $params
     * @return null
     */
    private function set_params($params) {
        $this->_params = array_merge($this->_params, $params);
        $this->params = $this->_params;
    }

    /**
     * Method to get url next and previous.
     * This method, set query body to url, given by constructor params
     * 
     * @param string $param Param to search to
     * @return string Url to request
     */
    private function get_paginated_url($param='next') {
        $page = $this->params['page'];
        $exclude = array_flip(array('url', 'prev', 'next', 'total'));
        if ($param === 'next' && ($this->params['total'] / $this->params['limit']) > $page) {
            $params = array_diff_key( array_merge(
                $this->params,
                array('page' => $page + 1)
            ), $exclude );
            return $this->get_url() . http_build_query($params);
        } elseif ($param === 'prev' && $page > 1) {
            $last_page = (int) ceil($this->params['total'] / $this->params['limit']);
            $params = array_diff_key( array_merge(
                $this->params,
                array('page' => $page > $last_page ? $last_page: $page - 1)
            ), $exclude );
            return $this->get_url() . http_build_query($params);
        }
        return null;
    }

    /**
     * Method to get the working query and set left params
     * 
     * @param array $query Array from query to paginate
     * @return array A sliced array
     */
    private function get_query_from_array($query) {
        $page = $this->params['page'];
        $limit = $this->params['limit'];
        $params['total'] = count($query);
        $this->set_params($params);

        return array_slice($query, ($page * $limit) - $limit, $limit);
    }

    /**
     * Method to get paginated response.
     * 
     * @param resource Function to apply to query array data;
     * @return array Response pagination
     */
    public function get_paginated_response($function) {

        $data = array();
        foreach ($this->query as $index => $post) {
            $result = $function($post, $index, $this->params);
            if ($result) {
                $data[] = $result;
            }
        }

        return array(
            'data' => $data,
            'pagination' => array_merge(
                $this->params,
                array(
                    'next' => $this->get_paginated_url('next'),
                    'prev' => $this->get_paginated_url('prev')
                )
            )
        );

    }

    /**
     * Returns the base urls plus given path
     * 
     * @return string
     */
    public function get_url() {
        return esc_url(home_url()) . '/wp-json/tpc-api' . $this->params['url'] . '?';
    }

}

?>
