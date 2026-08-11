# ArtOrganizer

ArtOrganizer é um projeto para organizar e gerenciar seus artigos.

## Instalação

Para instalar as dependências do projeto, execute:

```bash
composer install
```

## Uso

Para iniciar o servidor de desenvolvimento, execute:

```bash
php -S localhost:8000 -t public
```

## Uso com Docker

Crie o arquivo de ambiente a partir do exemplo e defina senhas seguras:

```bash
cp .env.example .env
```

Depois, inicie o projeto usando Docker:

```bash
docker compose up -d
```

O serviço do banco de dados será iniciado automaticamente. As credenciais são
definidas no arquivo `.env` e não devem ser versionadas.

## Contribuição

Se você deseja contribuir com o projeto, siga os passos abaixo:

1. Faça um fork do repositório.
2. Crie uma nova branch: `git checkout -b minha-branch`
3. Faça suas alterações e commit: `git commit -m 'Minha contribuição'`
4. Envie para o repositório remoto: `git push origin minha-branch`
5. Abra um Pull Request.

## Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
