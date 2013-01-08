<?php
namespace QuerySniffer\Model;


final class QuerySQLTypeEnum extends Enum
{
	const SQL_INSERT   = 'INSERT';
	const SQL_SELECT   = 'SELECT';
	const SQL_ALTER    = 'ALTER';
	const SQL_SHOW     = 'SHOW';
	const SQL_DELETE   = 'DELETE';
	const SQL_DROP     = 'DROP';
	const SQL_UPDATE   = 'UPDATE';
	const SQL_CREATE   = 'CREATE';
	const SQL_TRUNCATE = 'TRUNCATE';
	const SQL_SET      = 'SET';
	const SQL_PREPARE  = 'PREPARE';
	const SQL_EXECUTE  = 'EXECUTE';
	const SQL_FLUSH    = 'FLUSH';
	const SQL_DESCRIBE = 'DESCRIBE';
	const SQL_LOAD     = 'LOAD';
	const SQL_REVOKE   = 'REVOKE';
	const SQL_GRANT    = 'GRANT';
	const SQL_USE      = 'USE';
}