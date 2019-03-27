<div id="menu-left">
  <a href="org_list.php">
  	<div <?php if($left_selected == "LIST")
	  	{ echo 'class="menu-left-current-page"'; } ?>>
	  	<img src="./images/org_list.png"><br/>List<br/>
  	</div>
  </a>

  <a href="">
    <div <?php if($left_selected == "GLOBE")
    { echo 'class="menu-left-current-page"'; } ?>>
    <img src="./images/org_globe.png" >
    <br/>Globe<br/></div>
  </a>

  <a href="">
  	<div <?php if($left_selected == "TREE")
  	    { echo 'class="menu-left-current-page"'; } ?>>
  	    <img src="./images/org_tree.png"><br/>Tree<br/>
  	    </div>
  </a>

  <a href="">
  	<div <?php if($left_selected == "HYBRID")
  	    { echo 'class="menu-left-current-page"'; } ?>>
  	    <img src="./images/org_hybrid.png"><br/>Hybrid<br/>
  	</div>
  </a>
</div>
