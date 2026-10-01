<?php

function uploadImagem($id_usuario, $imagem)
{    
    $tamanhoDaImagem = 26214400;

    
    //Verifica se o arquivo foi enviado corretamente através de um formulário e se não houve nenhuma falha durante o processo de upload.
    if (isset($imagem) && ($imagem['error'] === UPLOAD_ERR_OK)) {
        //Se o arquivo é maior que 25 MB.
        if ($imagem['size'] > $tamanhoDaImagem) {
            return criaErro("A imagem deve ser menor do que 25MB");
        } elseif (is_uploaded_file($imagem['tmp_name']) === false) {
            return criaErro("Erro ao enviar imagem, tente novamente");
        }
        // Verificar se o formulário foi processado, mas o usuário não selecionou nenhum arquivo para enviar.
    } elseif (isset($imagem) && ($imagem['error'] === UPLOAD_ERR_NO_FILE)) {
        return null;
    } else {
        $errosGerais = [
            UPLOAD_ERR_INI_SIZE => "O arquivo excede o limite permitido.",
            UPLOAD_ERR_FORM_SIZE => "O arquivo excede o tamanho permitido.",
            UPLOAD_ERR_PARTIAL => "O upload foi interrompido.",
            UPLOAD_ERR_NO_TMP_DIR => "Erro ao enviar a imagem. Tente novamente mais tarde.",
            UPLOAD_ERR_CANT_WRITE => "Erro ao enviar a imagem. Tente novamente mais tarde.",
            UPLOAD_ERR_EXTENSION => "Erro ao enviar a imagem. Tente novamente mais tarde."
        ];
        $codigo = $imagem['error'];
        if (isset($errosGerais[$codigo])) {
            return criaErro($errosGerais[$codigo]);
        } else {
            return criaErro('Ocorreu um erro interno ao processar o seu arquivo.');
        }
    }

    $imagemEnviadaPeloUsuario = mime_content_type($imagem['tmp_name']);

    $extensaoDoMime = obterExtensaoAPartirDoMime($imagemEnviadaPeloUsuario);
    if (!is_string($extensaoDoMime)) {
        return $extensaoDoMime;
    }

    $diretorio = __DIR__ . '/../uploads/usuario_' . $id_usuario . '/';
    

    if (!is_dir($diretorio)) {        
        if(mkdir($diretorio, 0755) === false) {
            return criaErro('Erro ao criat diretoório');
        } 
    } 

    $countImagem = 1;
    $dataAtual = date('dmY');

    do {
        $countImagemFormatado = str_pad($countImagem, 3, "0", STR_PAD_LEFT);
        $nomeArquivoImagem = $id_usuario . '_' . $dataAtual . '_' . $countImagemFormatado . '.' . $extensaoDoMime;
        $caminhoRelativoDaImagem = '../uploads/usuario_' . $id_usuario . '/' . $nomeArquivoImagem;
        $caminhoCompletoArquivoImagem = $diretorio . $nomeArquivoImagem;
        if(file_exists($caminhoCompletoArquivoImagem)){
            $countImagem++;
        }
    } while (file_exists($caminhoCompletoArquivoImagem));
     
    if (!move_uploaded_file($imagem['tmp_name'], $caminhoCompletoArquivoImagem)) {
        return criaErro("Erro ao salvar o aquivo.");
    } else {
        return $caminhoRelativoDaImagem;
    }
    
}

function criaErro(string $validacao)
{
    return [
        "sucesso"  => false,
        "erro"     => true,
        "mensagem" => $validacao,

    ];
}

function obterExtensaoAPartirDoMime($mime)
{
    $mimeValidos =  [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];
    if (array_key_exists($mime, $mimeValidos)) {
        return $mimeValidos[$mime];
    } else {
        return criaErro('Erro ao obter extensão do arquivo.');
    }
}

 



/*
A sequência completa fica:

Verificar se existe arquivo.
Se não houver → retornar null.
Verificar se é um upload válido.
Verificar tamanho máximo de 25 MB.
Verificar o MIME real.
Verificar se o MIME é permitido.
Obter a extensão correspondente.
Garantir que o diretório usuario_X exista.
Gerar nome único.
Verificar se o nome já existe.
Salvar com move_uploaded_file().
Retornar o resultado.

E ainda temos a regra de retorno que você definiu:

null → sem imagem
status = 1 → sucesso + caminho
status = 0 → erro + mensagem

====================================
Verificar se houve arquivo
Verificar erro do upload
Verificar tamanho
Verificar MIME
Obter extensão
Verificar/criar diretório
Gerar nome único
Mover arquivo
Retornar resultado
*/