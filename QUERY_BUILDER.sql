SQL : SELECT name, age FROM product WHERE name LIKE '%key%';
Query: $this->db->table('product')->where('name', '=','quang')->where('id','>',3)->get();
SQL Result : SELECT * FROM product where name = "quang" and id > 3;
1. where(): $this->db->where(field,compare, value)
2. orWhere(): $this->db->orWhere(field, compare, value)
3. get(): $this->db->get()
4. first(): $this->db->first()
5. table(): $this->db->table(name)
6. join(): $this->db->join(tableName, condition)
7. limit(): $this->db->limit(offset, number)
8. insert(): $this->db->table(name)->insert(data)
9. update():$this->db->table(name)->where(field,compare, value)->update(data)
10. delete(): $this->db->table(name)->where(field, compare, value)->delete()
11. WhereLike(): $this->db->WhereLike(field, value)
12. select(): $this->db->select(field)
13. orderBy(): $his->db->orderBy(field, type)
14. lastId(): $this->db->lastId()