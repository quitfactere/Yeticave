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
  ('vasya@gmail.com', 'Vasya', '$2y$10$dJabGtNMhbsjttVCZkMaz.2X8OIICOyKseY/6VV6tVtF0GE9qffaG', '123456789'),
  ('petya@gmail.com', 'Petya', '$2y$10$TSil/3bQ0ztbdZ7giXhEbO1L2t/m6a4vYa6xQLM3AJhWPvqpNbkj.', '987654321');

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
('2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд готовый дать жару в любом парке', 'uploads/lot-1.jpg', 10999,'2022-10-30', 500, 1, 1),
('DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд готовый дать жару в любом парке', 'uploads/lot-2.jpg', 159999,'2022-10-23', 1000, 2, 1),
('Крепления Union Contact Pro 2015 года размер L/XL', 'Хорошие крепления, надежные и легкие', 'uploads/lot-3.jpg', 8000,'2022-10-25', 500, 2, 2),
('Ботинки для сноуборда DC Mutiny Charocal', 'Теплые и красивые ботинки', 'uploads/lot-4.jpg', 10999, '2022-10-26', 600, 1, 3),
('Куртка для сноуборда DC Mutiny Charocal', 'Легкая, теплая и прочная куртка', 'uploads/lot-5.jpg', 7500, '2022-10-27', 500, 1, 4),
('Маска Oakley Canopy', 'Желтые очки, все будет веселенькое', 'uploads/lot-6.jpg', 5400, '2022-10-28', 100, 1, 6);

insert into bets(price_bet, user_id, lot_id)
values(8500, 1, 4), (9000, 1, 4);

CREATE FULLTEXT INDEX lots_search ON lots(title, lot_description);