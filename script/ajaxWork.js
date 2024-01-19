function showProducts(){  
    $.ajax({
        url:"./manageProducts.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}
function showCustomers(){
    $.ajax({
        url:"./manageCustomer.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function showOrders(){
    $.ajax({
        url:"./viewOrders.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function showReports(){
    $.ajax({
        url:"./viewReports.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function showBills(){
    $.ajax({
        url:"./billreport.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}
