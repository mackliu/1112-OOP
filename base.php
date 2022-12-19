<?php 
class DB{
    protected $table;
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=school";
    protected $pdo;

    public function __construct($table)
    {
        $this->pdo=new PDO($this->dsn,'root','');
        $this->table=$table;
    }

    public function all(...$args){

    $sql="select * from $this->table ";

    if(isset($args[0])){
        if(is_array($args[0])){
            $tmp=$this->arrayToSqlArray($args[0]);

            $sql=$sql ." WHERE ". join(" && " ,$tmp);
        }else{
            //是字串
            $sql=$sql . $args[0];
        }
    }

    if(isset($args[1])){
        $sql = $sql . $args[1];
    }

    //echo $sql;
    return $this->pdo
                ->query($sql)
                ->fetchAll(PDO::FETCH_ASSOC);
    }

    function find($id){
        $sql="select * from `$this->table` ";

        if(is_array($id)){
            $tmp=$this->arrayToSqlArray($id);
            $sql = $sql . " where " . join(" && ",$tmp);
    
        }else{
    
            $sql=$sql . " where `id`='$id'";
        }
        //echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }


    function del($id){
        $sql="delete from `$this->table` ";

        if(is_array($id)){
            $tmp=$this->arrayToSqlArray($id);
            $sql = $sql . " where " . join(" && ",$tmp);
    
        }else{
    
            $sql=$sql . " where `id`='$id'";
        }

        //echo $sql;
        return $this->pdo->exec($sql);

    }

    function save($array){
        if(isset($array['id'])){
            //更新update
            $id=$array['id'];
            unset($array['id']);
            $tmp=$this->arrayToSqlArray($array);
            $sql ="update $this->table set ";
            $sql .=join(",",$tmp);
            $sql .=" where `id`='$id'";

        }else{
            //新增insert
            $cols=array_keys($array);
        
            $sql="insert into $this->table (`" . join("`,`",$cols) . "`) 
                                     values('" . join("','",$array) . "')";

        }
            //echo $sql;
            return $this->pdo->exec($sql);

    }

    function count(...$arg){

        $sql=$this->mathSql('count','*',$arg);
        //echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }

    function sum($col,...$arg){
        $sql=$this->mathSql('sum',$col,$arg);
       // echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }

    function max($col,...$arg){
        $sql=$this->mathSql('max',$col,$arg);

       // echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }

    function min($col,...$arg){
        $sql=$this->mathSql('min',$col,$arg);;

        //echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }

    function avg($col,...$arg){

        $sql=$this->mathSql('avg',$col,$arg);

       // echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }

    private function mathSql($math,$col,...$arg){
        if(isset($arg[0][0])){

            $tmp=$this->arrayToSqlArray($arg[0][0]);
            $sql="select $math($col) from $this->table where ";
            $sql.=join(" && ",$tmp);
        }else{

            $sql="select $math($col) from $this->table";
        }

        return $sql;
    }

    private function arrayToSqlArray($array){
        //dd($array);
        foreach($array as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        return $tmp;
    }

}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

//萬用sql函式
function q($sql){
    $dsn="mysql:host=localhost;charset=utf8;dbname=school";
    $pdo=new PDO($dsn,'root','');
    //echo $sql;
    return $pdo->query($sql)->fetchAll();
}

//header函式
function to($location){
    header("location:$location");
}

?>