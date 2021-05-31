# Microservice-based application sample

### This is still WIP

This is a simple implementation of the e-commerce application utilizing a microservice-based architecture.
Each microservice owns its own data/DB. Architecture per microservice varies from CRUD to DDD/CQRS patterns.
HTTP based communication between clients and the microservice via API Gateway. Async message-based communication between microservices handled by RabbitMQ.

Logging and monitoring: ELK, Grafana, Graphite, and StatsD

Read more:
- [API Gateway](api-gateway/README.md)
- [Cart](cart/README.md)
- [Order](order/README.md)
- [Product](product/README.md)
- [User](user/README.md)

TODO:
- Everything, I'll expand this list as I go.
- Add code quality tools (~~deptrac~~, ~~phpstan, phpcs-fixer~~, phpmd)
- Set up docker compose config for all services
- Add docker-compose-test.yaml and docker-compose-test.override.yaml to run the test suites
- Services:
    - Api gateway
        - use envoy
    - Cart
        - todo list
    - Order
        - todo list
    - Product
        - todo list
    - User
        - todo list
- Add https://docs.pact.io/ to test communication between services

WIP:
- Order: Receive integration event `User checkout accepted` and start order processing.
