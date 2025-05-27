# 🍻 Campeonato Mineiro de Bares, Butecos & Gandaias de BH

Sistema de ranking dinâmico que monitora, classifica e atualiza diariamente os bares mais populares de Belo Horizonte e Região Metropolitana. A pontuação é baseada em avaliações públicas (Google Reviews) e atualizada automaticamente todos os dias às 19h.

---

## 📌 Sobre o Projeto

Inspirado no formato do Campeonato Brasileiro de Futebol, este sistema organiza os 40 bares mais movimentados de BH em duas divisões:

- **Série A**: Top 20 bares com melhor desempenho
- **Série B**: Bares da 21ª à 40ª posição

O projeto valoriza a cultura boêmia mineira com uma pitada de inteligência de dados, gamificação e tecnologia de ponta.

---

## ⚙️ Stack Tecnológica

- PHP 8.4 (Hyperf Framework)
- Swoole (alta performance assíncrona)
- PostgreSQL 16
- Redis 7 (cache, filas)
- Docker + Docker Compose
- Composer 2
- Google Places API (reviews em tempo real)

---

## 🧪 Ambiente de Desenvolvimento

1. **Clone o repositório**

```bash
git clone https://github.com/arthurtavaresdev/campeonato-bares-bh.git
cd campeonato-bares-bh
```

2. **Configure as variáveis**

Copie o `.env.example` para `.env` e ajuste conforme sua necessidade

3. **Suba o ambiente com Docker**

```bash
docker-compose up -d --build
```

4. **Instale as dependências do projeto**

Como o volume do host é montado no container, o comando abaixo deve ser executado **após** a inicialização:

```bash
docker exec -it hyperf-app composer install
```

---

## 📈 Ranking e Regras

- Cálculo de score ponderado (média × log das avaliações / total)
- Regras de promoção/rebaixamento entre Séries A e B
- Agendamento diário via crontab Hyperf (`0 19 * * *`)

---

## 🧰 Comandos úteis

```bash
# Acessar container
docker exec -it hyperf-app bash

# Rodar servidor Hyperf
php bin/hyperf.php start

# Criar tarefa agendada (exemplo)
php bin/hyperf.php gen:crontab UpdateRankingCrontab
```

---

## 🧱 Contribuição

1. Fork o projeto
2. Crie uma branch: `feature/sua-ideia`
3. Commit: `git commit -m "feat: implementa nova funcionalidade"`
4. Push: `git push origin feature/sua-ideia`
5. Pull Request 🚀

---

## 📄 Licença

MIT © 2025 — Arthur Tavares

---

## ✨ Frase de inspiração

> “Quem não ama um bom boteco, bom sujeito não é.” — Ditado mineiro moderno
