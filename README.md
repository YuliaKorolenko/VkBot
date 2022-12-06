# VkBot
## База данных, внешний вид.
### group
Таблица, которая содержит информацию о каждой созданной группе.

| __id__ | name | reg_open | price |
|:---------:|:---------:|:---------:|:---------:|
| koshrodl | SantaSanta | 1 | 1 |

Будет генерироваться 8ми значный уникальный id для каждой группу, с помощью которого остальные участники смогут вступать а неё.

Также хранится флаг на то установлены ли нижние верхние границы цены.

regOpen - открыта ли регистрация. Пока регистрация открыта, пользователь можеть добавиться в событие.

### user

Таблица, которая содержит информацию о каждом участнике.

| id | page | __group_id__ | is_creator | vish_list |
|:---------:|:---------:|:---------:|:---------:|:---------:|
| 1 | ? | koshrodl | 1 | pen |
| 2 | ? | koshrodl | 0 | apple |

