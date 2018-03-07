<?php
/**
 * (C) Copyright 2017 Nuxeo SA (http://nuxeo.com/) and contributors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace Nuxeo\Client\Objects;


use Nuxeo\Client\Constants;
use Nuxeo\Client\Objects\Blob\Blob;
use Nuxeo\Client\Objects\Workflow\Workflow;
use Nuxeo\Client\Objects\Workflow\Workflows;
use Nuxeo\Client\Spi\ClassCastException;
use Nuxeo\Client\Spi\Http\Method\DELETE;
use Nuxeo\Client\Spi\Http\Method\GET;
use Nuxeo\Client\Spi\Http\Method\POST;
use Nuxeo\Client\Spi\Http\Method\PUT;
use Nuxeo\Client\Spi\NuxeoClientException;
use Nuxeo\Client\Spi\Objects\NuxeoEntity;


class Repository extends NuxeoEntity {

  /**
   * Repository constructor.
   * @param $nuxeoClient
   */
  public function __construct($nuxeoClient) {
    parent::__construct(Constants::ENTITY_TYPE_DOCUMENT, $nuxeoClient);
  }

  //region Documents

  /**
   * @param $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function fetchDocumentRoot($repositoryName = null, $type = null) {
    if(null !== $repositoryName) {
      return $this->fetchDocumentRootWithRepositoryName($repositoryName);
    }
    return $this->getResponseNew(GET::create('path'), $type);
  }

  /**
   * @param string $parentPath
   * @param Document $document
   * @param string $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function createDocumentByPath($parentPath, $document, $repositoryName = null, $type = null) {
    if(null !== $repositoryName) {
      return $this->createDocumentByPathWithRepositoryName($parentPath, $repositoryName, $document, $type);
    }
    return $this->getResponseNew(POST::create('path{parentPath}')
      ->setBody($document),
      $type);
  }

  /**
   * @param string $parentId
   * @param Document $document
   * @param string $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function createDocumentById($parentId, $document, $repositoryName = null, $type = null) {
    if(null !== $repositoryName) {
      return $this->createDocumentByIdWithRepositoryName($parentId, $repositoryName, $document, $type);
    }
    return $this->getResponseNew(POST::create('id/{parentId}')
      ->setBody($document),
      $type);
  }

  /**
   * @param string $documentPath
   * @param string $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function fetchDocumentByPath($documentPath, $repositoryName = null, $type = null) {
    if(null !== $repositoryName) {
      return $this->fetchDocumentByPathWithRepositoryName($documentPath, $repositoryName, $type);
    }
    return $this->getResponseNew(GET::create('path{documentPath}'), $type);
  }

  /**
   * @param string $documentId
   * @param string $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function fetchDocumentById($documentId, $repositoryName = null, $type = null) {
    if(null !== $repositoryName) {
      return $this->fetchDocumentByIdWithRepositoryName($documentId, $repositoryName, $type);
    }
    return $this->getResponseNew(GET::create('id/{documentId}'), $type);
  }

  /**
   * @param Document $document
   * @param string $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function updateDocument($document, $repositoryName = null, $type = null) {
    return $this->updateDocumentById($document->getUid(), $document, $repositoryName, $type);
  }

  /**
   * @param $path
   * @param $document
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function updateDocumentByPath($path, $document, $type = null) {
    return $this->getResponseNew(PUT::create('path{path}')
      ->setBody($document),
      $type);
  }

  /**
   * @param string $documentId
   * @param Document $document
   * @param string $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function updateDocumentById($documentId, $document, $repositoryName = null, $type = null) {
    if(null !== $repositoryName) {
      return $this->updateDocumentByIdWithRepositoryName($documentId, $repositoryName, $document, $type);
    }
    return $this->getResponseNew(PUT::create('id/{documentId}')
      ->setBody($document),
      $type);
  }

  /**
   * @param Document $document
   * @param string $repositoryName
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function deleteDocument($document, $repositoryName = null) {
    $this->deleteDocumentById($document->getUid(), $repositoryName);
  }

  /**
   * @param string $path
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function deleteDocumentByPath($path) {
    $this->getResponseNew(DELETE::create('path{path}'));
  }

  /**
   * @param string $documentId
   * @param string $repositoryName
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function deleteDocumentById($documentId, $repositoryName = null) {
    if(null !== $repositoryName) {
      $this->deleteDocumentByIdWithRepositoryName($documentId, $repositoryName);
    }
    $this->getResponseNew(DELETE::create('id/{documentId}'));
  }

  //endregion

  //region Documents with Repository filter

  /**
   * @param $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  protected function fetchDocumentRootWithRepositoryName($repositoryName, $type = null) {
    return $this->getResponseNew(GET::create('repo/{repositoryName}/path'), $type);
  }

  /**
   * @param string $documentPath
   * @param $repositoryName
   * @param null $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  protected function fetchDocumentByPathWithRepositoryName($documentPath, $repositoryName, $type = null) {
    return $this->getResponseNew(GET::create('repo/{repositoryName}/path{documentPath}'), $type);
  }

  /**
   * @param string $documentId
   * @param $repositoryName
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  protected function fetchDocumentByIdWithRepositoryName($documentId, $repositoryName, $type = null) {
    return $this->getResponseNew(GET::create('repo/{repositoryName}/id/{documentId}'), $type);
  }

  /**
   * @param string $parentId
   * @param string $repositoryName
   * @param Document $document
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  protected function createDocumentByIdWithRepositoryName($parentId, $repositoryName, $document, $type = null) {
    return $this->getResponseNew(POST::create('repo/{repositoryName}/id/{parentId}')
      ->setBody($document),
      $type);
  }

  /**
   * @param string $parentPath
   * @param string $repositoryName
   * @param Document $document
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  protected function createDocumentByPathWithRepositoryName($parentPath, $repositoryName, $document, $type = null) {
    return $this->getResponseNew(POST::create('repo/{repositoryName}/path{parentPath}')
      ->setBody($document),
      $type);
  }

  /**
   * @param string $documentId
   * @param string $repositoryName
   * @param Document $document
   * @param string $type
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  protected function updateDocumentByIdWithRepositoryName($documentId, $repositoryName, $document, $type = null) {
    return $this->getResponseNew(PUT::create('repo/{repositoryName}/id/{documentId}')
      ->setBody($document),
      $type);
  }

  /**
   * @param string $documentId
   * @param string $repositoryName
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  protected function deleteDocumentByIdWithRepositoryName($documentId, $repositoryName) {
    $this->getResponseNew(DELETE::create('repo/{repositoryName}/id/{documentId}'));
  }

  //endregion

  //region Query
  /**
   * @param string $query
   * @param int $pageSize
   * @param int $currentPageIndex
   * @param int $maxResults
   * @param string $sortBy
   * @param string $sortOrder
   * @param string $queryParams
   * @return mixed
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function query($query, $pageSize = 0, $currentPageIndex = 0, $maxResults = 200, $sortBy = '', $sortOrder = '', $queryParams = '') {
    return $this->getResponseNew(GET::create('query?query={query}&pageSize={pageSize}&currentPageIndex={currentPageIndex}&maxResults={maxResults}&sortBy={sortBy}&sortOrder={sortOrder}&queryParams={queryParams}'));
  }

  //endregion

  //region Children

  /**
   * @param $parentId
   * @return Documents
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function fetchChildrenById($parentId) {
    return $this->getResponseNew(GET::create('id/{parentId}/@children'),Documents::className);
  }

  //endregion

  //region Blobs

  /**
   * @param $documentId
   * @param $fieldPath
   * @return Blob
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function fetchBlobById($documentId, $fieldPath) {
    return $this->getResponseNew(GET::create('id/{documentId}/@blob/{fieldPath}'), Blob::className);
  }

  //endregion

  //region Workflows

  /**
   * @param string $documentId
   * @param string $repositoryName
   * @return Workflows
   */
  public function fetchWorkflowsById($documentId, $repositoryName = null) {
    if(null !== $repositoryName) {
      return $this->fetchWorkflowsByIdWithRepositoryName($documentId, $repositoryName);
    }
    return $this->getResponseNew(GET::create('id/{documentId}/@workflow'), Workflows::className);
  }

  /**
   * @param string $documentId
   * @param string $repositoryName
   * @return Workflows
   */
  public function fetchWorkflowsByIdWithRepositoryName($documentId, $repositoryName) {
    return $this->getResponseNew(GET::create('repo/{repositoryName}/id/{documentId}/@workflow'), Workflows::className);
  }

  /**
   * @param string $documentId
   * @param string $workflowModelName
   * @param string $repositoryName
   * @return Workflow
   * @throws NuxeoClientException
   * @throws ClassCastException
   */
  public function startWorkflowByNameWithDocId($workflowModelName, $documentId, $repositoryName = null) {
    return $this->startWorkflowWithDocId(Workflow::createFromModelName($workflowModelName), $documentId, $repositoryName);
  }

  /**
   * @param Workflow $workflow
   * @param string $documentId
   * @param string $repositoryName
   * @return Workflow
   */
  public function startWorkflowWithDocId($workflow, $documentId, $repositoryName = null) {
    if(null !== $repositoryName) {
      return $this->startWorkflowWithDocIdWithRepositoryName($workflow, $documentId, $repositoryName);
    }
    return $this->getResponseNew(POST::create('id/{documentId}/@workflow')
      ->setBody($workflow), Workflow::className);
  }

  /**
   * @param Workflow $workflow
   * @param string $documentId
   * @param string $repositoryName
   * @return Workflow
   */
  public function startWorkflowWithDocIdWithRepositoryName($workflow, $documentId, $repositoryName) {
    return $this->getResponseNew(POST::create('repo/{repositoryName}/id/{documentId}/@workflow')
      ->setBody($workflow), Workflow::className);
  }

  //endregion

}
