/**
 * Created by Luis on 04/02/2020.
 */
function showmethod(method)
{
    if(method == "cash")
    {
        $('#cash').css('display','block');
        $('#loan').css('display','none');
        $('#time').css('display','none');
    }
    else
    if(method == "loan")
    {
        $('#cash').css('display','none');
        $('#loan').css('display','block');
        $('#time').css('display','block');
    }
    else
    {
        $('#cash').css('display','block');
        $('#loan').css('display','block');
        $('#time').css('display','block');
    }
}
function editsellcar(id)
{
    $('#modaledit').modal('toggle');
    $('#modaledit').modal('hide');

    $.post('index.php', { operation: 'giveinfocar',idcar:id }, function(data){
        var brand = data[0].car_brand;
        var model = data[0].car_model;
        var year = data[0].car_year;
        var warranty = data[0].war_key_inside;
        var price = data[0].car_price;
        var image = data[0].car_img;
        $("#warranty option[value="+warranty+"]").prop("selected",true);
        $("#brand").val(brand);
        $("#model").val(model);
        $("#year").val(year);
        $("#price").val(price);
        $("#idcarhidden").val(id);

        document.getElementById('neweditpicture').src='sources/images/'+image;
    },"json");
}
function searchcar(search,userid)
{
    $.post('index.php', { operation: 'searchinfocar',search:search,userid:userid }, function(data){

        document.getElementById('rowscars').innerHTML = "";
        for(var i=0; i<data.length; i++)
        {
            var idcar = data[i].car_key_inside;
            var brand = data[i].car_brand;
            var model = data[i].car_model;
            var year = data[i].car_year;
            var warranty = data[i].war_months;
            var price = data[i].car_price;
            var image = data[i].car_img;

            document.getElementById('rowscars').innerHTML += "<tr><td>"+brand+"</td><td>"+model+"</td><td>"+year+"</td><td>"+warranty+"</td><td>"+price+"</td><td><img src='sources/images/"+image+"' class='imagecar'></td><td><a class='fa fa-edit cursor' onclick=editsellcar('"+idcar+"') title='Edit'><a></td><td><a class='fa fa-trash cursor' onclick=deletecar("+idcar+") title='Delete'><a></td></tr>";
        }
    },"json");
}
function edituser(id)
{
    $('#modaledit').modal('toggle');
    $('#modaledit').modal('hide');

    $.post('index.php', { operation: 'giveinfouser',iduser:id }, function(data){
        var user = data[0].use_username;
        var password = data[0].use_password;
        var name = data[0].use_name;
        var lastname = data[0].use_lastname;
        var phone = data[0].use_phone;
        var email = data[0].use_email;
        var address = data[0].use_address;
        var profile = data[0].use_profile;

        $("#inputuser").val(user);
        $("#inputpassword").val(password);
        $("#inputname").val(name);
        $("#inputlastname").val(lastname);
        $("#inputphone").val(phone);
        $("#inputemail").val(email);
        $("#inputaddress").val(address);
        $("#inputprofile option[value="+profile+"]").prop("selected",true);
        $("#iduserhidden").val(id);
    },"json");
}
function searchuser(search)
{
    $.post('index.php', { operation: 'searchinfouser',search:search }, function(data){
        document.getElementById('rowusers').innerHTML = "";
        for(var i=0; i<data.length; i++)
        {
            var use_key_inside = data[i].use_key_inside;
            var use_username = data[i].use_username;
            var use_name = data[i].use_name;
            var use_lastname = data[i].use_lastname;
            var use_phone = data[i].use_phone;
            var use_email = data[i].use_email;
            var use_address = data[i].use_address;
            var use_profile = data[i].use_profile;
            var profile = "";
            if(use_profile == 1){ profile = "Administrator"; }else{ profile = "Client"; }
            document.getElementById('rowusers').innerHTML += '<tr id="rowusers'+use_key_inside+'"> <td>'+use_username+'</td> <td>'+use_name+'</td> <td>'+use_lastname+'</td> <td>'+use_phone+'</td> <td>'+use_email+'</td> <td>'+use_address+'</td> <td>'+profile+'</td> <td><a class="fa fa-edit cursor" onclick=edituser('+use_key_inside+') title="Edit"><a></td> <td><a class="fa fa-trash cursor" onclick=deleteuser('+use_key_inside+') title="Delete"><a></td> </tr>';
        }
    },"json");
}
function deletecar(id)
{
    if(confirm("I your sure? Do you want ti delete this car"))
    {
        $.post('index.php', { operation: 'deletecar',idcar:id }, function(data){
            if(data > 0)
            {
                $("#rowcar"+id).fadeOut(3000);
            }
            else
            {
                alert("Try again");
            }
        });
    }
}
function deleteuser(id)
{
    if(confirm("I your sure? Do you want ti delete this user"))
    {
        $.post('index.php', { operation: 'deleteuser',iduser:id }, function(data){

            if(data > 0)
            {
                $("#rowusers"+id).fadeOut(3000);
            }
            else
            if(data == -1)
            {
                alert("This user have already bought cars, it is not posible to delete");
            }
            else
            {
                alert("Try again");
            }
        });
    }
}