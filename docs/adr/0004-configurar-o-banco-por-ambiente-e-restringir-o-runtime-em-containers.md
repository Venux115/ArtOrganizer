# ADR-0004: Configurar o banco por ambiente e restringir o runtime em containers

**Date**: 2026-08-11
**Status**: accepted
**Deciders**: Não documentado; backfill da decisão entregue em `fb92c05`

## Context

O commit `fb92c05` substitui credenciais fixas do Compose por variáveis de ambiente, adiciona `.env.example`, usa imagem PHP multiestágio e restringe o container da aplicação com usuário não privilegiado, sistema de arquivos somente leitura, volume específico para uploads e remoção de capacidades Linux. A implementação ainda mantém valores padrão de desenvolvimento em `Conexao`.

## Decision

A configuração de conexão do banco deve ser fornecida por variáveis de ambiente no Compose, com valores de exemplo versionados e segredos reais fora do Git. O container da aplicação deve executar como usuário não privilegiado, persistir apenas uploads e usar um sistema de arquivos somente leitura fora dessas áreas.

## Alternatives Considered

Nenhuma alternativa ou justificativa formal foi documentada antes da implementação.

## Consequences

### Positive

- Separa segredos e configuração do código versionado.
- Reduz a superfície de escrita e privilégios do processo da aplicação.
- Mantém banco e uploads persistentes entre recriações de containers.

### Negative

- A inicialização exige um arquivo `.env` válido.
- O ambiente fica dependente da estrutura de volumes declarada no Compose.

### Risks

- Os fallbacks `root` e `123` em `Conexao` podem ser usados indevidamente; removê-los ou restringi-los a desenvolvimento antes de produção.
- O volume local de uploads não oferece alta disponibilidade nem backup por si só.
