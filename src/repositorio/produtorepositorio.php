<?php

class produtorepositorio
{
    private PDO $pdo;

    public function __construct(pdo $pdo)
        {
            $this->pdo = $pdo;
        }

    private function formarobjeto($dados)
        {
            return new Produto(
                $dados['id'],
                $dados['tipo'],
                $dados['nome'],
                $dados['descricao'],
                $dados['preco'],
                $dados['imagem']
            );
        }

    public function opcoescafe():array

        {

            $sql1 = "SELECT * FROM produtos WHERE tipo = 'Café' ORDER BY preco";
            $statement = $this->pdo -> query($sql1);
            $produtoscafe = $statement -> fetchAll(PDO::FETCH_ASSOC);
            
            $dadoscafe = array_map(function($cafe){
                return $this->formarobjeto($cafe);
            },$produtoscafe);


    return $dadoscafe;

        }

    public function opcoeslanchesdamanha(): array

        {
        
            $sql2 = "SELECT * FROM produtos WHERE tipo = 'lanchesdamanha' ORDER BY preco";
            $statement = $this->pdo -> query($sql2);
            $produtoslanchesdamanha = $statement -> fetchAll(PDO::FETCH_ASSOC);

            $dadoslanchesdamanha = array_map(function($lanchesdamanha){
                return $this ->formarobjeto($lanchesdamanha);
            }, $produtoslanchesdamanha);
        
    return $dadoslanchesdamanha;

        }

    public function buscartodos()
        {
            $sql = "SELECT * FROM produtos ORDER BY preco";
            $statement = $this->pdo -> query($sql);
            $dados = $statement -> fetchAll(PDO::FETCH_ASSOC);

            $todososdados = array_map(function ($produto) {
                return $this->formarobjeto($produto);
            }, $dados);

            return $todososdados;
        }

    public function deletar(int $id)

        {
            $sql="DELETE FROM produtos WHERE id = ?";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $id);
            $statement->execute();
        }



    public function salvar(Produto $produto)
        {


            $sql = "INSERT INTO produtos (tipo, nome, descricao, preco, imagem) VALUES (?, ?, ?, ?, ?)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindvalue(1, $produto->gettipo());
            $statement->bindvalue(2, $produto->getnome());
            $statement->bindvalue(3, $produto->getdescricao());
            $statement->bindvalue(4, $produto->getpreco());
            $statement->bindvalue(5, $produto->getimagem());
            $statement->execute();



        }
    public function buscar(int $id)
        {
            $sql = "SELECT * FROM produtos WHERE id = ?";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $id);
            $statement->execute();

            $dados = $statement->fetch(PDO::FETCH_ASSOC);
            return $this->formarobjeto($dados);
        }

    public function atualizar(Produto $produto)
    {
        $sql = "UPDATE produtos SET tipo = ?, nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $produto->gettipo());
        $statement->bindValue(2, $produto->getnome());
        $statement->bindValue(3, $produto->getdescricao());
        $statement->bindValue(4, $produto->getpreco());
        $statement->bindValue(5, $produto->getimagem());
        $statement->bindValue(6, $produto->getId());
        $statement->execute();
    }

}
