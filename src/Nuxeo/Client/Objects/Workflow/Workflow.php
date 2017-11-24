<?php


namespace Nuxeo\Client\Objects\Workflow;


use JMS\Serializer\Annotation as Serializer;

class Workflow {

  const className = __CLASS__;

  /**
   * @var string
   * @Serializer\Type("string")
   */
  protected $id;

  /**
   * @var string
   * @Serializer\Type("string")
   */
  protected $name;

  /**
   * @var string
   * @Serializer\Type("string")
   */
  protected $title;

  /**
   * @var string
   * @Serializer\Type("string")
   */
  protected $state;

  /**
   * @var string
   * @Serializer\Type("string")
   */
  protected $workflowModelName;

  /**
   * @var string
   * @Serializer\Type("string")
   */
  protected $graphResource;

  /**
   * @param string $modelName
   * @return Workflow
   */
  public static function createFromModelName($modelName) {
    $workflow = new self();
    return $workflow->setWorkflowModelName($modelName);
  }

  /**
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param string $id
   * @return Workflow
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param string $name
   * @return Workflow
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @param string $title
   * @return Workflow
   */
  public function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  /**
   * @return string
   */
  public function getState() {
    return $this->state;
  }

  /**
   * @param string $state
   * @return Workflow
   */
  public function setState($state) {
    $this->state = $state;
    return $this;
  }

  /**
   * @return string
   */
  public function getWorkflowModelName() {
    return $this->workflowModelName;
  }

  /**
   * @param string $workflowModelName
   * @return Workflow
   */
  public function setWorkflowModelName($workflowModelName) {
    $this->workflowModelName = $workflowModelName;
    return $this;
  }

  /**
   * @return string
   */
  public function getGraphResource() {
    return $this->graphResource;
  }

  /**
   * @param string $graphResource
   * @return Workflow
   */
  public function setGraphResource($graphResource) {
    $this->graphResource = $graphResource;
    return $this;
  }

}
