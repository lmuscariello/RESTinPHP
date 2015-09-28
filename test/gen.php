<?php
   
    require_once(dirname(__FILE__) . "/../src/restinphp/Request.php");
    use restinphp\Request as Request;

    $req = new Request();
?>
<HTML>
    <HEAD>
        <TITLE>Request Object Tests</TITLE>
        <style type="text/css">
            div.stat {
                display: block;
                width: 100%;
            }
            div.test span {
                font-weight: bold;
            }
        </style>
    </HEAD>
    <BODY>
        <h1>Request Object Tests</h1>
        <div class="stat"><span>Method: </span><?php print($req->getMethod()); ?></div>
        <div class="stat"><span>IsPost: </span><?php print($req->isPost()); ?></div>
        <div class="stat"><span>IsGet: </span><?php print($req->isGet()); ?></div>
        <div class="stat"><span>IsHead: </span><?php print($req->isHead()); ?></div>
        <div class="stat"><span>IsPut: </span><?php print($req->isPut()); ?></div>
        <div class="stat"><span>IsDelete: </span><?php print($req->isDelete()); ?></div>
        <div class="stat"><span>IsOptions: </span><?php print($req->isOptions()); ?></div>
        <h2>Body As JSON</h2>
        <p>
            <?php print_r($req->asJSON()); ?>
        </p>  
    </BODY>
</HTML>