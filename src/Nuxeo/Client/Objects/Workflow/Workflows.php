<?php


namespace Nuxeo\Client\Objects\Workflow;


use JMS\Serializer\Annotation as Serializer;
use Nuxeo\Client\Constants;
use Nuxeo\Client\Spi\Http\Method\GET;
use Nuxeo\Client\Spi\Objects\NuxeoEntity;

class Workflows extends NuxeoEntity {

  const className = __CLASS__;

  /**
   * @var Workflow[]
   * @Serializer\Type("array<Nuxeo\Client\Objects\Workflow\Workflow>")
   * @Serializer\SerializedName("entries")
   */
  private $workflows;

  /**
   * Workflows constructor.
   * @param \Nuxeo\Client\NuxeoClient $nuxeoClient
   */
  public function __construct($nuxeoClient) {
    parent::__construct(Constants::ENTITY_TYPE_WORKFLOWS, $nuxeoClient);
  }

  /**
   * @return Workflow[]
   */
  public function fetchModels() {
    /** @var Workflows $workflows */
    $workflows = $this->getResponseNew(GET::create('workflowModel'), self::className);
    if($workflows) {
      return $workflows->getWorkflows();
    }
  }

  /**
   * @return Workflow[]
   */
  public function getWorkflows() {
    return $this->workflows;
  }

  /**
   * @param int $position
   * @return Workflow
   */
  public function get($position) {
    return $this->workflows[$position];
  }

  /**
   * @return int
   */
  public function size() {
    return count($this->workflows);
  }

}
