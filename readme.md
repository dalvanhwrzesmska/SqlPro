# Classe SqlPro

A classe `SqlPro` é uma utilidade em PHP projetada para simplificar interações com bancos de dados MySQL usando MySQLi. Ela fornece métodos para executar operações SQL comuns, como SELECT, INSERT, UPDATE e DELETE, além de oferecer funcionalidades de log e depuração.

## Funcionalidades

- **Log de SQL**: Registra consultas SQL com parâmetros para fins de depuração.
- **Operações de Busca**: Recupera uma ou várias linhas do banco de dados.
- **Inserção, Atualização e Exclusão**: Métodos simplificados para modificar registros no banco de dados.
- **Tratamento de Erros**: Fornece mensagens detalhadas em caso de falhas.

## Requisitos

- PHP 7.0 ou superior
- Extensão MySQLi habilitada
- Conexão válida com um banco de dados MySQL

## Instalação

1. Clone ou baixe este repositório.
2. Inclua o arquivo `SqlPro.php` no seu projeto:
   ```php
   require_once '....seucaminho/SqlPro.php';
   ```

3. Crie uma conexão MySQLi e passe-a para a classe `SqlPro`:
   ```php
   $conn = new mysqli('localhost', 'usuario', 'senha', 'banco_de_dados');
   $sqlPro = new SqlPro($conn);
   ```

## Como Usar

### 1. Buscar Todas as Linhas
Recupere todas as linhas de uma tabela.
```php
$sql = "SELECT * FROM usuarios WHERE idade > ?";
$params = [18];
$tipos = "i"; // 'i' para inteiro

$resultado = $sqlPro->sql_fetch_all($sql, $params, $tipos);
print_r($resultado->sql);
```

### 2. Buscar Uma Linha
Recupere uma única linha de uma tabela.
```php
$sql = "SELECT * FROM usuarios WHERE id = ?";
$params = [1];
$tipos = "i";

$resultado = $sqlPro->sql_fetch($sql, $params, $tipos);
print_r($resultado->sql);
```

### 3. Inserir Dados
Insira um novo registro em uma tabela.
```php
$sql = "INSERT INTO usuarios (nome, idade) VALUES (?, ?)";
$params = ["João Silva", 25];
$tipos = "si"; // 's' para string, 'i' para inteiro

$resultado = $sqlPro->sql_insert($sql, $params, $tipos);
echo "ID Inserido: " . $resultado->insert_id;
```

### 4. Atualizar Dados
Atualize um registro existente em uma tabela.
```php
$sql = "UPDATE usuarios SET idade = ? WHERE id = ?";
$params = [30, 1];
$tipos = "ii";

$resultado = $sqlPro->sql_update($sql, $params, $tipos);
echo "Linhas Afetadas: " . $resultado->affected_rows;
```

### 5. Excluir Dados
Exclua um registro de uma tabela.
```php
$sql = "DELETE FROM usuarios WHERE id = ?";
$params = [1];
$tipos = "i";

$resultado = $sqlPro->sql_delete($sql, $params, $tipos);
echo "Linhas Afetadas: " . $resultado->affected_rows;
```

### 6. Registrar Consultas SQL
Registre consultas SQL com parâmetros em um arquivo para depuração.
```php
$sql = "SELECT * FROM usuarios WHERE idade > ?";
$params = [18];
$tipos = "i";

$sqlPro->sql_log($sql, $params, $tipos);
```

### 7. Retornar SQL com Parâmetros
Obtenha a consulta SQL com os parâmetros substituídos para depuração.
```php
$sql = "SELECT * FROM usuarios WHERE idade > ?";
$params = [18];
$tipos = "i";

$sqlComParametros = $sqlPro->sql_log_return($sql, $params, $tipos);
echo $sqlComParametros;
```

## Tratamento de Erros

Cada método retorna um objeto contendo o status da operação, o número de linhas afetadas e mensagens de erro, se houver. Por exemplo:
```php
$resultado = $sqlPro->sql_update($sql, $params, $tipos);
if ($resultado->status === 'success') {
    echo "Operação bem-sucedida!";
} else {
    echo "Erro: " . $resultado->error;
}
```

## Licença

Este projeto está licenciado sob a Licença MIT. Sinta-se à vontade para usá-lo e modificá-lo conforme necessário.

## Contribuições

Contribuições são bem-vindas! Por favor, faça um fork deste repositório e envie um pull request com suas alterações.

## Autor

Desenvolvido por Dalvan Hoffmann Wrzesmska. Para dúvidas ou suporte, entre em contato dalvanhoffmannwrzesmska@gmail.com.