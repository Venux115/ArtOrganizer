# ADR-0002: Modelar organização de artigos por relacionamentos no banco relacional

**Date**: 2023-11-20
**Status**: accepted
**Deciders**: Vinícius Goulart e colaboradores do ArtOrganizer (backfill histórico)

## Context

O esquema MariaDB representa usuários, pastas e artigos em tabelas próprias. As associações `pasta_user` e `artigo_pasta` registram, respectivamente, a posse de pastas e a organização de artigos nelas. Cada cadastro cria uma pasta `root` para o usuário.

## Decision

A aplicação usa MariaDB e tabelas de associação para representar a posse de pastas e a relação entre pastas e artigos. A privacidade do artigo é armazenada como `priv` ou `pub` e orienta as consultas de exploração e pesquisa pública.

## Alternatives Considered

Nenhuma alternativa foi documentada no histórico do repositório.

## Consequences

### Positive

- A relação entre usuário, pasta e artigo é consultável por joins.
- O modelo permite organizar artigos sem acoplar a estrutura de pastas à tabela de usuários.

### Negative

- Exclusões exigem remover previamente relações de associação.
- A pasta `root` é uma convenção de domínio distribuída entre cadastro e consultas.

### Risks

- Falhas de autorização podem expor ou alterar recursos de outro usuário; as operações por identificador devem sempre validar a posse pela relação `pasta_user`.
