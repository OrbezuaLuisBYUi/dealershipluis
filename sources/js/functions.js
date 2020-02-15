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