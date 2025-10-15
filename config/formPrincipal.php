<?php
//  dd($_GET);
if (isset($_GET['action'])) {
    // echo $_GET['action'];
    // dd($_GET) ;
    // dd($_GET['action']) ;
    switch ($_GET['action']) {
        case 'getImpressionPDF':
            echo "Dieu est grand";
            ?>
            <script>
                
            </script>
            <?php
            break;
        default:
            echo 'Merci';
            break;
    }
}

?>