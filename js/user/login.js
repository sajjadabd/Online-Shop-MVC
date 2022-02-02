var submitButtons = document.getElementsByClassName("submitButton");

var textInputs = document.getElementsByClassName("tab");

for(i=0;i<textInputs.length;i++)
{
    textInputs[i].style.display = "none";
}

var currentTextInput = 0;
textInputs[currentTextInput].style.display = "";
textInputs[currentTextInput].querySelector('input').focus();


prev = 0;
nex = 1;
submit = 2;

for(i=0;i<submitButtons.length;i++)
{
    submitButtons[i].style.display = "none";
}

submitButtons[nex].style.display = "";

/*
function next(number)
{
    currentTextInput += number;

    if(currentTextInput >= textInputs.length-1)
        currentTextInput = textInputs.length-1;
    if(currentTextInput <= 0)
        currentTextInput = 0;

    if(currentTextInput == 0)
    {
        submitButtons[prev].style.display = "none";
        submitButtons[nex].style.display = "";
        submitButtons[submit].style.display = "none";
    }
    else if ( currentTextInput == textInputs.length-1 )
    {
        submitButtons[prev].style.display = "";
        submitButtons[nex].style.display = "none";
        submitButtons[submit].style.display = "";
    }
    else
    {
        submitButtons[prev].style.display = "";
        submitButtons[nex].style.display = "";
        submitButtons[submit].style.display = "none";
    }


    for(i=0;i<textInputs.length;i++)
    {
        textInputs[i].style.display = "none";
    }
    textInputs[currentTextInput].style.display = "";
    textInputs[currentTextInput].querySelector('input').focus();
    //console.log(currentTextInput);
}

*/