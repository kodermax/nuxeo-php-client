<?php


namespace Nuxeo\Client\Tests;


use Nuxeo\Client\Objects\Document;
use Nuxeo\Client\Tests\Framework\TestCase;

class WorkflowTest extends TestCase {

  /**
   * @var \Nuxeo\Client\Objects\Document
   */
  private $document;

  const WORKFLOW_MODEL = 'ParallelDocumentReview';

  protected function setUp() {
    parent::setUp();

    $document = Document::create()->setType('note')->setName('note');

    $this->getClient()->addResponse($this->createJsonResponseFromFile('document.json'));

    $this->document = $this->getClient()
      ->repository()
      ->createDocumentByPath('/', $document);
  }

  public function testListWorkflowModels() {
    $this->getClient()->addResponse($this->createJsonResponseFromFile('workflowModels.json'));

    $models = $this->getClient()
      ->workflows()
      ->fetchModels();

    $this->assertCount(2, $models);
  }

  public function testListDocumentWorkflows() {
    $this->getClient()->addResponse($this->createJsonResponseFromFile('documentWorkflows.json'));
    $workflows = $this->document->fetchWorkflows();

    $this->assertEquals(1, $workflows->size());

    $this->assertEquals(self::WORKFLOW_MODEL, $workflows->get(0)->getWorkflowModelName());
  }

  public function testStartDocumentWorkflow() {
    $this->getClient()->addResponse($this->createJsonResponseFromFile('documentWorkflow.json'));
    $workflow = $this->document->startWorkflow(self::WORKFLOW_MODEL);

    $this->assertEquals(self::WORKFLOW_MODEL, $workflow->getWorkflowModelName());
  }

}
