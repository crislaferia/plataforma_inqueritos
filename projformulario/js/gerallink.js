// Função para gerar uma string aleatória
function gerarLinkAleatorio(tamanho) {
    const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let link = '';
    for (let i = 0; i < tamanho; i++) {
      const indice = Math.floor(Math.random() * caracteres.length);
      link += caracteres.charAt(indice);
    }
    return link;
  }
  
  // Usando a função para gerar um link aleatório de 8 caracteres
  const linkAleatorio = gerarLinkAleatorio(8);
 
  const linkCompleto = "http://localhost/plataforma_inqueritos/projformulario/php/pagina_respostas.php?="+linkAleatorio;
  console.log(linkCompleto);

