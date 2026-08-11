# ADR-0001: Adotar MVC com front controller e repositórios

**Date**: 2023-11-24
**Status**: accepted
**Deciders**: Vinícius Goulart e colaboradores do ArtOrganizer (backfill histórico)

## Context

A aplicação concentra a entrada HTTP em `public/index.php`, resolve rotas por método e caminho em `config/router.php` e instancia controladores. Entidades representam os dados do domínio e repositórios isolam as operações `mysqli`. A justificativa original não está documentada; este ADR registra a arquitetura já estabelecida.

## Decision

A aplicação usa um front controller com uma tabela explícita de rotas, controladores para cada caso de uso HTTP, entidades de domínio e repositórios para persistência. As views PHP permanecem responsáveis pela apresentação.

## Alternatives Considered

Nenhuma alternativa foi documentada no histórico do repositório.

## Consequences

### Positive

- Centraliza o despacho HTTP e torna as rotas visíveis em um único arquivo.
- Separa acesso a dados das views e dos controladores.

### Negative

- A composição manual de dependências em `public/index.php` cresce com a aplicação.
- Controladores ainda concentram parte da validação e da coordenação de fluxos.

### Risks

- Alterações de rota ou dependências podem falhar apenas em execução; manter validações automatizadas para rotas e fluxos críticos.
