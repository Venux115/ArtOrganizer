# ADR-0003: Usar Docker Compose para a topologia local da aplicação

**Date**: 2024-08-16
**Status**: accepted
**Deciders**: Vinícius Goulart e colaboradores do ArtOrganizer (backfill histórico)

## Context

O repositório passou a fornecer Dockerfile, `docker-compose.yml` e o script SQL de inicialização para executar PHP e MariaDB como serviços separados. O banco persiste seus dados em volume nomeado e o esquema é disponibilizado como inicialização do serviço.

## Decision

A aplicação é executada em dois serviços Docker Compose: a aplicação PHP e o MariaDB. O banco usa volume nomeado para dados persistentes, e o esquema inicial é fornecido pelo repositório.

## Alternatives Considered

Nenhuma alternativa foi documentada no histórico do repositório.

## Consequences

### Positive

- Padroniza a execução local e elimina dependências de instalação manual do banco.
- Separa processo da aplicação, armazenamento do banco e rede entre serviços.

### Negative

- O ambiente de desenvolvimento passa a depender de Docker e Compose.
- O script de inicialização não substitui uma estratégia evolutiva de migrações.

### Risks

- Alterações no schema após a criação do volume não são aplicadas automaticamente; definir migrações antes de evoluções incompatíveis.
