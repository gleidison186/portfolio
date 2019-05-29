$(function(){
  $("#form-test").on("submit",function(){
    nome_input = $("input[name='nome']");

    if(nome_input.val() == "" || nome_input.val() == null)
    {
      $("#erro-nome").html("O nome eh obrigatorio.");
      return(false);
    }

    email_input = $("input[name='email']");

    if(email_input.val() == "" || email_input.val() == null)
    {
      $("#erro-email").html("O email eh obrigatorio.");
      return(false);
    }

    senha_input = $("input[name='senha']");

    if(senha_input.val() == "" || senha_input.val() == null)
    {
      $("#erro-senha").html("A senha é obrigatoria");
      return(false);
    }
    return(true);
  });
});
