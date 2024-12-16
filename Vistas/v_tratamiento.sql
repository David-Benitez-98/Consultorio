-- View: v_tratamiento

-- DROP VIEW v_tratamiento;

CREATE OR REPLACE VIEW v_tratamiento AS 
 SELECT t.tra_cod,
    t.usu_cod,
    t.pac_cod,
    (p.per_nombre::text || ' '::text) || p.per_apellido::text AS paciente,
    t.diag_cod,
    t.tra_fecha,
    t.tra_estado
   FROM tratamiento t
     JOIN usuarios u ON t.usu_cod = u.usu_cod
     JOIN pacientes pa ON t.pac_cod = pa.pac_cod
     JOIN persona p ON p.per_cod = pa.per_cod;

ALTER TABLE v_tratamiento
  OWNER TO postgres;
