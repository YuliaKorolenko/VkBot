# VkBot
## Secret Santa
you can:
1. Create group with friends
2. Add your wishes
3. Receive a friend's wish, when creator of group end group registration.
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

![telegram-cloud-photo-size-2-5294189926042161633-y](https://github.com/YuliaKorolenko/VkBot/assets/79725120/1d41a8ab-7c42-42ec-a2a2-5ebf8e914b62)

![telegram-cloud-photo-size-2-5267476883023447033-y](https://github.com/YuliaKorolenko/VkBot/assets/79725120/b7a4e76a-b7ed-41de-8a21-250fe468df2f)
