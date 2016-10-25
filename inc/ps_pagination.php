<style type="text/css">
    .blackbtn {background-color:#000066; border:1px solid  #E2E4F1; font-family:Verdana;font-size:12px;color:#6f6e65; padding:0px; cursor: pointer; color:#ffffff; }
    .style4 {font-family:Verdana;font-size:12px;color:#6f6e65; font-weight: bold; }
    h4{font-family:arial; font-size:11px; font-weight:bold; color:#FFFFFF; padding:0px; margin:0px;}


    /* PAGINATOR Flickr */
    /*actual .PagesFlickr { text-align: center; margin-bottom: 20px; margin-top: 20px; }*/
    .PagesFlickr {font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6f6e65; margin-bottom: 20px; margin-top: 20px; }
    .Paginator { font-family:Verdana;font-size:12px;color:#FF0000; padding-top: 10px; margin-left: auto; margin-right: auto; /* padding-bottom: 10px;  background-image: url(http://l.yimg.com/g/images/dotted.gif); background-repeat: repeat-x; background-position: left bottom; */ }
    .Paginator a, .pageList .this-page {font-family:Verdana;font-size:12px;color:#FF0000; padding: 2px 6px; border: solid 1px #ddd; background: #FFFFFF; text-decoration: none; }
    .Paginator a:visited { padding: 2px 6px; border: solid 1px #ddd; background: #FFFFFF; text-decoration: none; }
    .Paginator .AtStart { margin-right: 20px; padding: 2px 6px; /* border: solid 1px #ddd; */ background: #FF0000; font-family:Verdana;font-size:12px;color:#FF0000; }
    .Paginator .Prev { margin-right: 20px; padding: 2px 6px; border: solid 2px #ddd; background: #e3e3d7; font-family:Verdana;font-size:12px;color:#FF0000; }
    .Paginator .break { padding: 2px 6px; border: none; background: #e3e3d7; text-decoration: none; }
    .Paginator .Next { margin-left: 20px; padding: 2px 6px; border: solid 2px #ddd; background: #e3e3d7; font-family:Verdana;font-size:12px;color:#FF0000;} 
    .Paginator .AtEnd { margin-left: 20px; padding: 2px 6px; /* border: solid 1px #ddd; */ background: #e3e3d7; font-family:Verdana;font-size:12px;color:#6f6e65; }
    .Paginator .this-page {padding: 2px 6px; border-color: #999;  vertical-align: top; background: #FFFFFF; font-family:Verdana;font-size:12px;color:#FF0000; }
    .Paginator a:hover {font-family:Verdana;font-size:12px;color:#FF0000; background:#E1E1E1; border-color: #036; text-decoration: none;}
    /* 
    .Paginator .ranking {display: block; margin-top: 0.5em; font-weight: bold;}
    .Paginator .ranking a {padding: 0; border: 0; background: transparent;} 
    */
    .Pages div.Results { text-align: center; font: 11px/15px Arial, Helvetica; color: #aaa; margin-top: 8px; }
</style>
<?php

class PS_Pagination {

    var $php_self;
    var $rows_per_page = 10; //Number of records to display per page
    var $total_rows = 0; //Total number of rows returned by the query
    var $links_per_page = 5; //Number of links to display per page
    var $append = ""; //Paremeters to append to pagination links
    var $sql = "";
    var $debug = false;
    var $conn = true;
    var $page = 1;
    var $max_pages = 0;
    var $offset = 0;
    var $sqlType = '';

    function PS_Pagination($db, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "", $sqlType = 'join') {
        $this->conn = $db;
        $this->sql = $sql;
        $this->rows_per_page = (int) $rows_per_page;
        if (intval($links_per_page) > 0) {
            $this->links_per_page = (int) $links_per_page;
        } else {
            $this->links_per_page = 5;
        }
        $this->append = $append;
        $this->php_self = htmlspecialchars($_SERVER['PHP_SELF']);
        if (isset($_GET['page'])) {
            $this->page = intval($_GET['page']);
        }
        $this->sqlType = $sqlType;
        
    }

    function paginate() {
        //Check for valid  connection
        if (!$this->conn) {
            if ($this->debug)
                echo "Mongo Db connection missing....<br />";
            return false;
        }

        $this->total_rows = $this->conn->numRows($this->sql['mainCollection'], $this->sql['match']);
        if (!$this->total_rows) {
            return false;
        }

        //Max number of pages
        $this->max_pages = ceil($this->total_rows / $this->rows_per_page);
        if ($this->links_per_page > $this->max_pages) {
            $this->links_per_page = $this->max_pages;
        }

        //Check the page value just in case someone is trying to input an aribitrary value
        if ($this->page > $this->max_pages || $this->page <= 0) {
            $this->page = 1;
        }

        //Calculate Offset
        $this->offset = $this->rows_per_page * ($this->page - 1);

        //Fetch the required result set
        if($this->sqlType == 'join'){
           $rs = $this->conn->lookup($this->sql, $this->offset, $this->rows_per_page);
        }else{
           $keys = key($this->sql['sort']);
           $rs = $this->conn->find($this->sql['mainCollection'], $this->sql['match'], $keys, $this->sql['sort'][$keys], $this->offset, $this->rows_per_page); 
        } 

        if (!$rs) {
            if ($this->debug)
                echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . mysql_error();
            return false;
        }
        return $rs;
    }

    function renderFirst($tag = 'First') {
        if ($this->total_rows == 0)
            return FALSE;

        if ($this->page == 1) {
            return "<span class=\"this-page\">$tag </span>";
        } else {
            return '<span class="Paginator"><a href="' . $this->php_self . '?page=1&' . $this->append . '">' . $tag . '</a></span> ';
        }
    }

    function renderLast($tag = 'Last') {
        if ($this->total_rows == 0)
            return FALSE;

        if ($this->page == $this->max_pages) {
            return $tag;
        } else {
            return '<span class="Paginator"> <a href="' . $this->php_self . '?page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a></span>';
        }
    }

    function renderNext($tag = '&gt;&gt;') {
        if ($this->total_rows == 0)
            return FALSE;

        if ($this->page < $this->max_pages) {
            return '<span class="Paginator"><a href="' . $this->php_self . '?page=' . ($this->page + 1) . '&' . $this->append . '">' . $tag . '</a></span>';
        } else {
            return $tag;
        }
    }

    function renderPrev($tag = '&lt;&lt;') {
        if ($this->total_rows == 0)
            return FALSE;

        if ($this->page > 1) {
            return '<span class="Paginator"> <a href="' . $this->php_self . '?page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a></span>';
        } else {
            return " $tag";
        }
    }

    function renderNav($prefix = '<span class="Paginator">', $suffix = '</span>') {
        if ($this->total_rows == 0)
            return FALSE;

        $batch = ceil($this->page / $this->links_per_page);
        $end = $batch * $this->links_per_page;
        if ($end == $this->page) {
            //$end = $end + $this->links_per_page - 1;
            //$end = $end + ceil($this->links_per_page/2);
        }
        if ($end > $this->max_pages) {
            $end = $this->max_pages;
        }
        $start = $end - $this->links_per_page + 1;
        $links = '';

        for ($i = $start; $i <= $end; $i ++) {
            if ($i == $this->page) {
                $links .= $prefix . " $i " . $suffix;
            } else {
                $links .= ' ' . $prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '">' . $i . '</a>' . $suffix . ' ';
            }
        }

        return $links;
    }

    function renderFullNav() {
        return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
    }

    function setDebug($debug) {
        $this->debug = $debug;
    }

}
?>
