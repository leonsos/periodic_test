-- SQL request(s)​​​​​​‌​​‌​‌‌‌‌‌​‌​​‌‌​‌​​‌‌​‌​ below
select st.FirstName,st.LastName,AVG(st.Score) as AvgScore
FROM Students st
where (select avg(Score) from Students st1  where st.FirstName = st1.FIRSTNAME and st.LastName = st1.LASTNAME) > 0.9
Group by st.FIRSTNAME, st.LASTNAME
order by st.Score DESC, st.FirstName ASC



SELECT FIRSTNAME, LASTNAME
FROM customer
WHERE ZIPCODE IN (75000,34000) AND BIRTH_DATE <> NULL