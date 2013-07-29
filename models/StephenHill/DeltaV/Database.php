<?

namespace StephenHill\DeltaV
{
	use \PDO;
	
	class Database
	{
		public $Connection;
		
		public function __construct()
		{
			$this->Connection = new PDO('mysql:dbname=deltav;host=localhost', 'deltav', 'deltav');
		}
		
		public function GetByID($table, $id)
		{
			
		}
		
		public function Add($table, $kvp)
		{
			$query = 'INSERT INTO ' . $table . ' SET ';
			
			foreach($kvp as $key => $value)
			{
				$query .= "`$key` = :" . str_replace('-', '', $key);
				
				end($kvp);
				
				if ($key !== key($kvp))
				{
					$query .= ',';
				}
			}
			
			$statement = $this->Connection->prepare($query);
			
			foreach($kvp as $key => $value)
			{
				$statement->bindValue(':' . str_replace('-', '', $key), $value);
			}
			
			$statement->execute();
			
			var_dump($statement->errorInfo());
		}
	}
}