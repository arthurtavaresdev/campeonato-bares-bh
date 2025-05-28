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

- PHP 8.3 (Hyperf Framework)
- Swoole (alta performance assíncrona)
- PostgreSQL 16
- Redis 7 (cache, filas)
- Docker + Docker Compose
- Composer 2
- Google Places API (reviews em tempo real)

---

## 🧪 Ambiente de Desenvolvimento

1. Clone o repositório:

```bash
git clone https://github.com/arthurtavaresdev/campeonato-bares-bh.git
cd campeonato-bares-bh
```

2. Configure as variáveis:

Copie o `.env.example` para `.env`

3. Suba com Docker:

```bash
docker-compose up -d --build
```

Acesse: [http://localhost:9501](http://localhost:9501)

---

## 🧰 Dicas úteis

- Renomeie `composer.json` e `docker-compose.yml` com o nome do seu projeto.
- Veja os arquivos `config/routes.php` e `app/Controller/IndexController.php` para entender o fluxo HTTP.
- Customize o conteúdo deste README para refletir sua aplicação.

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
