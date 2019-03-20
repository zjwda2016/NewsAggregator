<?php
//Survey.php
namespace SurveySez;

/**
 * Survey Class retrieves data info for an individual Survey
 * 
 * The constructor an instance of the Survey class creates multiple instances of the 
 * Question class and the Answer class to store questions & answers data from the DB.
 *
 * Properties of the Survey class like Title, Description and TotalQuestions provide 
 * summary information upon demand.
 * 
 * A survey object (an instance of the Survey class) can be created in this manner:
 *
 *<code>
 *$mySurvey = new SurveySez\Survey(1);
 *</code>
 *
 * In which one is the number of a valid Survey in the database. 
 *
 * The forward slash in front of IDB picks up the global namespace, which is required 
 * now that we're here inside the SurveySez namespace: \IDB::conn()
 *
 * The showQuestions() method of the Survey object created will access an array of question 
 * objects and internally access a method of the Question class named showAnswers() which will 
 * access an array of Answer objects to produce the visible data.
 *
 * @see Question
 * @see Answer 
 * @todo none
 */
 
class Survey
{
	 public $SurveyID = 0;
	 public $Title = "";
	 public $Description = "";
	 public $isValid = FALSE;
	 public $TotalQuestions = 0; #stores number of questions
	 protected $aQuestion = Array();#stores an array of question objects
	
	/**
	 * Constructor for Survey class. 
	 *
	 * @param integer $id The unique ID number of the Survey
	 * @return void 
	 * @todo none
	 */ 
    function __construct($id)
	{#constructor sets stage by adding data to an instance of the object
		$this->SurveyID = (int)$id;
		if($this->SurveyID == 0){return FALSE;}
		
		#get Survey data from DB
		$sql = sprintf("select Title, Description from wn19_surveys Where SurveyID =%d",$this->SurveyID);
		
		#in mysqli, connection and query are reversed!  connection comes first
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
		if (mysqli_num_rows($result) > 0)
		{#Must be a valid survey!
			$this->isValid = TRUE;
			while ($row = mysqli_fetch_assoc($result))
			{#dbOut() function is a 'wrapper' designed to strip slashes, etc. of data leaving db
			     $this->Title = dbOut($row['Title']);
			     $this->Description = dbOut($row['Description']);
			}
		}
		@mysqli_free_result($result); #free resources
		
		if(!$this->isValid){return;}  #exit, as Survey is not valid
		
		#attempt to create question objects
		$sql = sprintf("select QuestionID, Question, Description from wn19_questions where SurveyID =%d",$this->SurveyID);
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
		if (mysqli_num_rows($result) > 0)
		{#show results
		   while ($row = mysqli_fetch_assoc($result))
		   {
				#create question, and push onto stack!
				$this->aQuestion[] = new Question(dbOut($row['QuestionID']),dbOut($row['Question']),dbOut($row['Description'])); 
		   }
		}
		$this->TotalQuestions = count($this->aQuestion); //the count of the aQuestion array is the total number of questions
		@mysqli_free_result($result); #free resources
		
		#attempt to load all Answer objects into cooresponding Question objects 
	    $sql = "select a.AnswerID, a.Answer, a.Description, a.QuestionID from wn19_surveys s inner join wn19_questions q on q.SurveyID=s.SurveyID inner join wn19_answers a on a.QuestionID=q.QuestionID where s.SurveyID = %d order by a.AnswerID asc";
		$sql = sprintf($sql,$this->SurveyID); #process SQL
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
		if (mysqli_num_rows($result) > 0)
		{#at least one answer!
		   while ($row = mysqli_fetch_assoc($result))
		   {#match answers to questions
			    $QuestionID = (int)$row['QuestionID']; #process db var
				foreach($this->aQuestion as $question)
				{#Check db questionID against Question Object ID
					if($question->QuestionID == $QuestionID)
					{
						$question->TotalAnswers += 1;  #increment total number of answers
						#create answer, and push onto stack!
						$question->aAnswer[] = new Answer((int)$row['AnswerID'],dbOut($row['Answer']),dbOut($row['Description']));
						break; 
					}
				}	
		   }
		}
	}# end Survey() constructor
	
	/**
	 * Reveals questions in internal Array of Question Objects 
	 *
	 * @param none
	 * @return string prints data from Question Array 
	 * @todo none
	 */ 
	function showQuestions()
	{
		$myReturn = '';
      
      	if($this->TotalQuestions > 0)
		{#be certain there are questions
			foreach($this->aQuestion as $question)
			{#print data for each
              /*
				$myReturn .= $question->QuestionID . " ";
				$myReturn .= $question->Text . " ";
				$myReturn .= $question->Description . "<br />";
				#call showAnswers() method to display array of Answer objects
				$myReturn .= $question->showAnswers() . "</p>";
                */
              	$myReturn .= '
      			<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
            					<p class="mb-1 mt-3 font-weight-bold text-muted">'. $question->Text.'</p>
								
            					<select class="form-control select2" data-toggle="select2">
                                <option>--Select--</option>
            						'. $question->showAnswers().'
            					</select>
        					
                            </div> <!-- end col -->
                    	</div> <!-- end row -->
             		</div> <!-- end card-body-->
        		 </div> <!-- end card-->
      			';
			}
		}else{
			$myReturn .= "There are currently no questions for this survey.";	
		}
      	/*
      	$myReturn = '';
        if($this->TotalQuestions > 0)
		{#be certain there are questions
			foreach($this->aQuestion as $question)
			{#print data for each
                $myReturn .= '<p>';
				$myReturn .= $question->QuestionID . " ";
				$myReturn .= $question->Text . " ";
				$myReturn .= '<em>' . $question->Description . "</em><br />";
				#call showAnswers() method to display array of Answer objects
				$myReturn .= $question->showAnswers() . "</p>";
			}
		}else{
			$myReturn .= "There are currently no questions for this survey.";	
		}*/
        return $myReturn;
	}# end showQuestions() method
    
}# end Survey class