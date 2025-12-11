<?php
    session_start();
    date_default_timezone_set('Asia/Kolkata');
    include('conn_db.php');
            $tid = $_POST["tid"];
            $cftid = $_POST["cftid"];
            if($tid!=$cftid){
                ?>
                <script>
                    alert('Your transaction id  is not match.\nPlease enter it again.');
                    history.back();
                </script>
                <?php
                exit(1);
            }
    
    
    
    $tournament_query = "SELECT s_id FROM tournament
    WHERE s_id = (SELECT s_id FROM cart WHERE c_id = {$_SESSION['cid']} GROUP BY c_id)";
    $tournament_arr = $mysqli -> query($tournament_query) -> fetch_array();
    $tournament_id = $tournament_arr["s_id"];
       
       $gt_query = "SELECT SUM(ct.ct_amount*f.f_price) AS grandtotal FROM cart ct INNER JOIN matches f 
       ON ct.f_id = f.f_id WHERE ct.c_id = {$_SESSION['cid']} GROUP BY ct.c_id";
       $gt_arr = $mysqli -> query($gt_query) -> fetch_array();
       $order_cost = $gt_arr["grandtotal"];
            
       
        
      
            
            
            $payment_query = "INSERT INTO payment (c_id,p_amount) VALUES ({$_SESSION['cid']},{$order_cost});\n";
            $payment_result = $mysqli -> query($payment_query);
            $pay_id = $mysqli -> insert_id;
            $orh_query = "INSERT INTO mreg_status (c_id,s_id,p_id,t_id,orh_orderstatus) VALUES ({$_SESSION['cid']},{$tournament_id},{$pay_id},'$tid','VRFY');\n";
            $orh_result = $mysqli -> query($orh_query);
            $orh_id = $mysqli -> insert_id;
            $ord_vl = "";
            $crt_query = "SELECT ct.f_id,f.f_price,ct.ct_amount,ct.ct_note FROM cart ct INNER JOIN matches f ON ct.f_id = f.f_id WHERE ct.c_id = {$_SESSION['cid']} AND ct.s_id = {$tournament_id};\n";
            $crt_result = $mysqli -> query($crt_query);
            $crt_row = $crt_result -> num_rows;
            $i = 0;
            while($crt_arr = $crt_result -> fetch_array()){
                $i++;
                $ord_vl .= "({$orh_id},{$crt_arr['f_id']},{$crt_arr['ct_amount']},{$crt_arr['f_price']},'{$crt_arr['ct_note']}')";
                if($i<$crt_row){
                    $ord_vl .= ",";
                }else{
                    $ord_vl .= ";";
                }
            }
            
            $ord_query = "INSERT INTO mreg_detail (orh_id,f_id,ord_amount,ord_buyprice,ord_note) VALUES {$ord_vl}\n";
            $ord_result = $mysqli -> query($ord_query);
            
                $crtdlt_query = "DELETE FROM cart WHERE c_id = {$_SESSION['cid']} AND s_id = {$tournament_id};\n";
                $crtdlt_result = $mysqli -> query($crtdlt_query);
                header("location: reg_verify.php?orh={$orh_id}");
            
            
               
    
    
?>