<?php
class paginationClass
{
	private $db; 
	private $user_id;
	private $company_id;
	 
	function __construct()
	{
		$this->db = getDB();
@		$this->user_id = $_SESSION['uid'];
@		$this->company_id = $_SESSION['company_id'];
	}


	public function paging($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page_no"]))
		{
			$starting_position=($_GET["page_no"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position,$records_per_page";
		return $query2;
	}
	 
	public function paginglink($query,$records_per_page,$val,$params)
	{
	  
		$self = $_SERVER['PHP_SELF'];
	  
		$stmt = $this->db->prepare($query);
		$stmt->execute($params);
	  
		$total_no_of_records = $stmt->rowCount();
	  
		if($total_no_of_records > 0)
		{
		?>
			<ul class="pagination">
			<?php
		   $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
		   $current_page=1;
		   
			if(isset($_GET["page_no"]))
			{
				$current_page=$_GET["page_no"];
			}
			if($current_page!=1)
			{
				$previous =$current_page-1;
				echo "<li><a href='".$self."?".$val."page_no=1'>First</a></li>";
				echo "<li><a href='".$self."?".$val."page_no=".$previous."'>Previous</a></li>";
			}
			for($i=1;$i<=$total_no_of_pages;$i++)
			{
				if($i==$current_page)
				{
					echo "<li><a href='".$self."?".$val."page_no=".$i."' style='color:red;'>".$i."</a></li>";
				}
				else
				{
					echo "<li><a href='".$self."?".$val."page_no=".$i."'>".$i."</a></li>";
				}
			}
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				echo "<li><a href='".$self."?".$val."page_no=".$next."'>Next</a></li>";
				echo "<li><a href='".$self."?".$val."page_no=".$total_no_of_pages."'>Last</a></li>";
			}
			?>
			</ul>
			<?php
		}
	}
	 
 /* paging */ 
}
?>