<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 23/05/2017
 * Time: 17:55
 */
namespace JSantos\Lib;

trait LibTrait
{
    protected $nomes = [
        'name',
        'nome',
        'sobrenome',
        'lastname',
        'nome_produto',
        'produto',
        'product',
        'status_name',
    ];

    protected $senha = [
        'senha',
        'pass',
        'password',
        'remember_token',
        'token',
    ];

    protected $imagem = [
        'image',
        'imagem',
        'thumb',
        'thumbnail',
        'avatar',
        'picture',
        'foto',
        'photo',
        'capture',
        'pintura',
        'print',
    ];

    protected $idades = [
        'age',
        'idade',
    ];

    protected $ano = [
        'year',
        'ano',
    ];

    protected $endereço = [
        'address',
        'endereco',
        'local',
    ];

    protected $cidade = [
        'city',
        'cidade',
    ];
    protected $estado = [
        'state',
        'estado',
    ];
    protected $date = [
        'date',
        'data',
        'cadastro',
        'cadastrado',
        'nascimento',
        'aniversario',
        'created_at',
        'updated_at',
    ];
    protected $telefone = [
        'tel',
        'telephone',
        'telefone',
        'cel',
        'celular',
        'cellphone',
    ];
    protected $username = [
        'user',
    'username',];

    protected $email = [
        'email',
    ];

    protected $numero = [
        'number',
        'numero',
        'inteiro',
        'int',
    ];

    protected $id = [
        'user_id',
        'ator_id',
        'product_id',
        'produto_id',
    ];

    protected $descricao = [
        'description',
        'descricao',
        'resumo',
        'text',
        'texto',
        'txt',
    ];

    protected $dinheiro = [
        'real',
        'valor',
        'price',
        'preco',
        'dinheiro',
        'money',
        'value',
    ];
}