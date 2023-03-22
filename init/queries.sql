insert into
  categories(character_code, category_name)
values
  ('boards', 'Доски и лыжи'),
  ('attachment', 'Крепления'),
  ('boots', 'Ботинки'),
  ('clothing', 'Одежда'),
  ('tools', 'Инструменты'),
  ('other', 'Разное');

insert into
  users(email, user_name, user_password, contacts)
values
  ('vasya @gmail.com', 'Vasya', 'vasya_pass', '123456789'),
  ('petya @gmail.com', 'Petya', 'petya_pass', '987654321');

insert into
  lots(
    title,
    lot_description,
    image_path,
    start_price,
    date_finish,
    step,
    user_id,
    category_id
  )
values
('2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд готовый дать жару в любом парке', 'img/lot-1.jpg', 10999,'2022-10-30', 500, 1, 1),
('DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд.ю готовый дать жару в любом парке', 'img/lot-2.jpg', 159999,'2022-10-23', 1000, 2, 1),
('Крепления Union Contact Pro 2015 года размер L/XL', 'Хорошие крепления, надежные и легкие', 'img/lot-3.jpg', 8000,'2022-10-25', 500, 2, 2),
('Ботинки для сноуборда DC Mutiny Charocal', 'Теплые и красивые ботинки', 'img/lot-4.jpg', 10999, '2022-10-26', 600, 1, 3),
('Куртка для сноуборда DC Mutiny Charocal', 'Легкая, теплая и прочная куртка', 'img/lot-5.jpg', 7500, '2022-10-27', 500, 1, 4),
('Маска Oakley Canopy', 'Желтые очки, все будет веселенькое', 'img/lot-6.jpg', 5400, '2022-10-28', 100, 1, 6);

insert into bets(price_bet, user_id, lot_id)
values(8500, 1, 4), (9000, 1, 4);

/*получить все категории*/
SELECT * FROM categories;

/*получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории*/
SELECT lots.title, lots.image_path, lots.start_price, categories.category_name FROM lots
JOIN categories ON lots.category_id = categories.id;

/*показать лот по его ID. Получите также название категории, к которой принадлежит лот*/
SELECT lots.id, lots.date_creation, lots.title, lots.lot_description, lots.image_path, lots.start_price, lots.date_finish, categories.category_name 
FROM lots JOIN categories ON lots.category_id = categories.id;

/*обновить название лота по его идентификатору*/
UPDATE lots SET title =  'Ботинки для сноуборда обычные' WHERE id=4;

/*получить список ставок для лота по его идентификатору с сортировкой по дате*/
SELECT lots.title, bets.bet_date, bets.price_bet, users.user_name FROM lots
JOIN bets ON bets.lot_id = lots.id
JOIN users ON users.id = bets.user_id
WHERE lots.id = 4
ORDER BY bets.bet_date DESC;