<?php

//$Id: block_html.php,v 1.8 2005/05/19 20:09:57 defacer Exp $

class block_library extends block_base {

	function init() {
		$this->title = get_string('pluginname', 'block_library');
	}

	function instance_allow_config() {
		return true;
	}
	function applicable_formats() {
		return array (
			'all' => true
		);
	}

	function specialization() {
    global $CFG;
    if($CFG->configtitle)
    {
    $this->config->title = $CFG->configtitle;
   
    }
    else {
      $this->config->title = 'UPEI Library Resources';
    }
     $this->title = $this->config->title;
		
	}

	function has_config() {
		return true;
	}

	function instance_allow_multiple() {
		return true;
	}

	function get_content() {
		global $CFG, $editing, $COURSE, $USER;
		require_once ($CFG->libdir . '/rsslib.php');
		require_once ($CFG->libdir.'/simplepie/moodle_simplepie.php');

		//require_login();
		if ($this->content !== NULL) {
			return $this->content;
		}

		$this->content = new stdClass;
    global $CFG;
    $this->config->text=$CFG->configcontent;
		$this->content->text = $this->config->text;
		$this->content->text .=getRSS("http://resources.library.upei.ca/dbofdbs/courseDBRssFeed.php?course=$COURSE->idnumber");
		$this->content->text .=getStaticStuff();
    
        return $this->content;
	}
}

function getRSS($rssURL) {
	$output = '';
  $simplepie = new SimplePie();
  $simplepie->set_feed_url($rssURL);
  $simplepie->init();
  if ($simplepie->get_item_quantity() != 0) {
    $title = $simplepie->get_title();
    $output .= $title;
  }
	$output=$output.'<ul style="list-style-position: outside; margin-left: 0; padding-left: 1em; margin-top: 0; padding-top 0;">';

	if ($simplepie->get_item_quantity() != 0) {
    foreach ($simplepie->get_items() as $item) {
      $_title = $item->get_title();
      $_url = $item->get_link();
      $output = $output . "<li><a href='$_url' target=\"_blank\">$_title</a></li>";
    }
  }
	$output=$output."</ul>";
	return $output;
}
function getStaticStuff(){
	$craftyLink = <<<EOF
	
<div class="textout window">JavaScript disabled or chat unavailable.</div>

<div class="textin window">Chat Is Unavailable</div>
</div>
</div>
<!-- Place this script as near to the end of your BODY as possible. --><script type="text/javascript">
  (function() {
    var x = document.createElement("script"); x.type = "text/javascript"; x.async = true;
    x.src = (document.location.protocol === "https:" ? "https://" : "http://") + "ca.libraryh3lp.com/js/libraryh3lp.js?50411";
    var y = document.getElementsByTagName("script")[0]; y.parentNode.insertBefore(x, y);
  })();
</script>  
</div>

EOF;
	// this is the previous version of the libraryh3lp code.
	/* .= "<script src=\"https://ca.libraryh3lp.com/js/libraryh3lp.js?multi\" type=\"text/javascript\"></script>
  <div class=\"needs-js\" style=\"display: none\" oldblock=\"block\">Library ASK US requires JavaScript. </div>
  <div class=\"libraryh3lp\" style=\"display: block\" oldblock=\"block\" jid=\"upeimoodle@chat.ca.libraryh3lp.com\"><iframe style=\"border-right: #4d759a 1px solid; border-top: #4d759a 1px solid; border-left: #4d759a 1px solid; width: 170px; border-bottom: #4d759a 1px solid; height: 180px\" src=\"https://ca.libraryh3lp.com/chat/upeimoodle@chat.ca.libraryh3lp.com?skin=7721&theme=gota&title=Library%20ASK%20US&identity=library%20staff\" frameborder=\"1\"></iframe></div>
  <div class=\"libraryh3lp\" style=\"display: none\">Library ASK US is currently offline. Please <a href=\"http://library.upei.ca/node/527\">check our other contact options.</a> </div>
  <div><br /></div>" ;
       */
    $craftyLink .= "<div  style=\"margin-bottom: 0; padding-bottom: 0;\"><a href='http://library.upei.ca/' target='_blank'>Library Homepage</a><br/>";
	$craftyLink .= "<a href= 'http://library.upei.ca/hours' target='_blank'>Library Hours</a><br/>";
	$craftyLink .= "<a href= 'https://rooms.library.upei.ca' target='_blank'>Book A Room</a><br/>";
	$craftyLink .='<!-- EBSCOhost Custom Search Box Begins --><script src="http://support.epnet.com/eit/scripts/ebscohostsearch.js" type="text/javascript"></script><style type="text/css">.choose-db-list{ list-style-type:none;padding:0;margin:0px 0 0 0;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:9pt;width:160px; }		.choose-db-check{ width:0px;float:left;padding-left:0px;padding-top:0px; }		.choose-db-detail{ margin-left:0px;border-left:solid 1px #E7E7E7;padding:0px 0px 0px 0px;line-height:1.4em; }		.summary { background-color:#1D5DA7;color:#FFFFFF;border:solid 1px #1D5DA7; }		.one { background-color: #FFFFFF;border:solid 1px #E7E7E7;border-top:solid 1px #FFFFFF; }		.two { background-color: #F5F5F5;border:solid 1px #E7E7E7;border-top:solid 1px #FFFFFF; }		.selected { background-color: #E0EFF7;border:solid 1px #E7E7E7;border-top:solid 1px #FFFFFF; }		#ebscohostCustomSearchBox #disciplineBlock { width:auto; }		#ebscohostCustomSearchBox .limiter { float:left;margin:0;padding:0;width:50%; }		#ebscohostsearchtext { width: 150px; }		#ebscohostsearchtext.edspub { width: 150px; }				.ebscohost-search-button.edspub {			border: 1px solid #156619;			padding: 0px 0px !important;			border-radius: 0px;			color: #fff;			font-weight: bold;			background-color: #156619;		}				.ebscohost-title.edspub {			color: #1c7020;			font-weight: bold;		}</style><form action="" id="ebscohostCustomSearchBox" method="post" onsubmit="return ebscoHostSearchGo(this);" style="width:150px; overflow:auto;"><input id="ebscohostwindow" name="ebscohostwindow" type="hidden" value="1" /> <input id="ebscohosturl" name="ebscohosturl" type="hidden" value="http://proxy.library.upei.ca/login?url=http://search.ebscohost.com/login.aspx?direct=true&amp;site=eds-live&amp;scope=site&amp;type=0&amp;mode=bool&amp;lang=en&amp;authtype=ip" /> <input id="ebscohostsearchsrc" name="ebscohostsearchsrc" type="hidden" value="db" /> <input id="ebscohostsearchmode" name="ebscohostsearchmode" type="hidden" value="+" /> <input id="ebscohostkeywords" name="ebscohostkeywords" type="hidden" value="" /><div style="height:80px; width:150px; font-family:Verdana,Arial,Helvetica,sans-serif;font-size:9pt; color:#353535;"><div style="padding-top:0px;padding-left:0px;"><div><input id="ebscohostsearchtext" name="ebscohostsearchtext" size="23" style="font-size:9pt;padding-left:0px;margin-left:0px;" type="text" value="OneSearch" /> <input class="ebscohost-search-button " style="font-size:9pt;padding-left:0px;" type="submit" value="Go" /><div id="guidedFieldSelectors"><input checked="checked" class="radio" id="guidedField_0" name="searchFieldSelector" type="hidden" value="" /></div></div></div></div>';

	return $craftyLink;
}
?>
