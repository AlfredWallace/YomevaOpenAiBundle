<?php

namespace Yomeva\OpenAiBundle\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Yomeva\OpenAiBundle\Exception\NotImplementedException;
use Yomeva\OpenAiBundle\Model\File\UploadFilePayload;

class OpenAiClient
{
    private HttpClientInterface $client;

    public function __construct(private readonly string $openAiApiKey)
    {
        $this->client = HttpClient::create()
            ->withOptions(
                (new HttpOptions())
                    ->setBaseUri('https://api.openai.com/v1/')
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('Authorization', "Bearer {$this->openAiApiKey}")
                    ->setHeader('OpenAI-Beta', 'assistants=v2')
                    ->toArray()
            );
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function basicRequest(string $method, string $url, array $payload = []): ResponseInterface
    {
        return $this->client->request($method, $url, empty($payload) ? [] : ['json' => $payload]);
    }

    ///> AUDIO

    // POST https://api.openai.com/v1/audio/speech
    public function createSpeech(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/audio/transcriptions
    public function createTranscription(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/audio/translations
    public function createTranslation(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< AUDIO


    ///> CHAT

    // POST https://api.openai.com/v1/chat/completions
    public function createChatCompletion(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< CHAT


    ///> EMBEDDINGS

    // POST https://api.openai.com/v1/embeddings
    public function createEmbeddings(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< EMBEDDINGS


    ///> FINE-TUNING

    // POST https://api.openai.com/v1/fine_tuning/jobs
    public function createFineTuningJob(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/fine_tuning/jobs
    public function listFineTuningJobs(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/fine_tuning/jobs/{fine_tuning_job_id}/events
    public function listFineTuningEvents(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/fine_tuning/jobs/{fine_tuning_job_id}/checkpoints
    public function listFineTuningCheckpoints(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/fine_tuning/jobs/{fine_tuning_job_id}
    public function retrieveFineTuningJob(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/fine_tuning/jobs/{fine_tuning_job_id}/cancel
    public function cancelFineTuningJob(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< FINE-TUNING


    ///> BATCH

    // POST https://api.openai.com/v1/batches
    public function createBatch(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/batches/{batch_id}
    public function retrieveBatch(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/batches/{batch_id}/cancel
    public function cancelBatch(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/batches
    public function listBatches(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< BATCH


    ///> FILES

    /**
     * @throws TransportExceptionInterface
     */
    public function uploadFile(UploadFilePayload $payload): ResponseInterface
    {
        $handle = fopen($payload->uploadedFile->getRealPath(), 'r');
        stream_context_set_option($handle, 'http', 'filename', $payload->uploadedFile->getClientOriginalName());

        return $this->client->request(
            'POST',
            'files',
            [
                'body' => [
                    'purpose' => $payload->purpose,
                    'file' => $handle,
                ]
            ]
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function listFiles(): ResponseInterface
    {
        return $this->basicRequest('GET', 'files');
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function retrieveFile(string $fileId): ResponseInterface
    {
        return $this->basicRequest('GET', "files/$fileId");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function deleteFile(string $fileId): ResponseInterface
    {
        return $this->basicRequest('DELETE', "files/$fileId");
    }

    ///< FILES


    ///> UPLOADS

    // POST https://api.openai.com/v1/uploads
    public function createUpload(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/uploads/{upload_id}/parts
    public function addUploadPart(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/uploads/{upload_id}/complete
    public function completeUpload(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/uploads/{upload_id}/cancel
    public function cancelUpload(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< UPLOADS


    ///> IMAGES

    // POST https://api.openai.com/v1/images/generations
    public function createImage(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/images/edits
    public function createImageEdit(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/images/variations
    public function createImageVariation(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< IMAGES


    ///> MODELS

    /**
     * @throws TransportExceptionInterface
     */
    public function listModels(): ResponseInterface
    {
        return $this->basicRequest('GET', 'models');
    }

    // GET https://api.openai.com/v1/models/{model}
    public function retrieveModel(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // DELETE https://api.openai.com/v1/models/{model}
    public function deleteModel(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< MODELS


    ///> MODERATIONS

    // POST https://api.openai.com/v1/moderations
    public function createModeration(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< MODERATIONS


    ///> ASSISTANT

    /**
     * @throws TransportExceptionInterface
     */
    public function createAssistant(array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', 'assistants', $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function listAssistants(): ResponseInterface
    {
        return $this->basicRequest('GET', 'assistants');
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function retrieveAssistant(string $assistantId): ResponseInterface
    {
        return $this->basicRequest('GET', "assistants/$assistantId");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function modifyAssistant(string $assistantId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "assistants/$assistantId", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function deleteAssistant(string $assistantId): ResponseInterface
    {
        return $this->basicRequest('DELETE', "assistants/$assistantId");
    }

    ///< ASSISTANT


    ///> THREADS

    /**
     * @throws TransportExceptionInterface
     */
    public function createThread(array $payload = []): ResponseInterface
    {
        return $this->basicRequest('POST', 'threads', $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function retrieveThread(string $threadId): ResponseInterface
    {
        return $this->basicRequest('GET', "threads/$threadId");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function modifyThread(string $threadId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "threads/$threadId", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function deleteThread(string $threadId): ResponseInterface
    {
        return $this->basicRequest('DELETE', "threads/$threadId");
    }

    ///< THREADS


    ///> MESSAGES

    /**
     * @throws TransportExceptionInterface
     */
    public function createMessage(string $threadId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "threads/$threadId/messages", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function listMessages(string $threadId): ResponseInterface
    {
        return $this->basicRequest('GET', "threads/$threadId/messages");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function retrieveMessage(string $threadId, string $messageId): ResponseInterface
    {
        return $this->basicRequest('GET', "threads/$threadId/messages/$messageId");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function modifyMessage(string $threadId, string $messageId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "threads/$threadId/messages/$messageId", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function deleteMessage(string $threadId, string $messageId): ResponseInterface
    {
        return $this->basicRequest('DELETE', "threads/$threadId/messages/$messageId");
    }

    ///< MESSAGES


    ///> RUNS

    /**
     * @throws TransportExceptionInterface
     */
    public function createRun(string $threadId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "threads/$threadId/runs", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function createThreadAndRun(array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', 'threads/runs', $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function listRuns(string $threadId): ResponseInterface
    {
        return $this->basicRequest('GET', "threads/$threadId/runs");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function retrieveRun(string $threadId, string $runId): ResponseInterface
    {
        return $this->basicRequest('GET', "threads/$threadId/runs/$runId");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function modifyRun(string $threadId, string $runId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "threads/$threadId/runs/$runId", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function submitToolsOutputsToRun(string $threadId, string $runId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "threads/$threadId/runs/$runId/submit_tool_outputs", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function cancelRun(string $threadId, string $runId): ResponseInterface
    {
        return $this->basicRequest('POST', "threads/$threadId/runs/$runId/cancel");
    }

    ///< RUNS


    ///> RUN STEPS

    // GET https://api.openai.com/v1/threads/{thread_id}/runs/{run_id}/steps
    public function listRunSteps(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/threads/{thread_id}/runs/{run_id}/steps/{step_id}
    public function retrieveRunStep(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< RUN STEPS


    ///> VECTOR STORES

    /**
     * @throws TransportExceptionInterface
     */
    public function createVectorStore(array $payload = []): ResponseInterface
    {
        return $this->basicRequest('POST', 'vector_stores', $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function listVectorStores(): ResponseInterface
    {
        return $this->basicRequest('GET', 'vector_stores');
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function retrieveVectorStore(string $vectorStoreId): ResponseInterface
    {
        return $this->basicRequest('GET', "vector_stores/$vectorStoreId");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function modifyVectorStore(string $vectorStoreId, array $payload = []): ResponseInterface
    {
        return $this->basicRequest('POST', "vector_stores/$vectorStoreId", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function deleteVectorStore(string $vectorStoreId): ResponseInterface
    {
        return $this->basicRequest('DELETE', "vector_stores/$vectorStoreId");
    }

    ///< VECTOR STORES


    ///> VECTOR STORE FILES

    /**
     * @throws TransportExceptionInterface
     */
    public function createVectorStoreFile(string $vectorStoreId, array $payload): ResponseInterface
    {
        return $this->basicRequest('POST', "vector_stores/$vectorStoreId/files", $payload);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function listVectorStoresFiles(string $vectorStoreId): ResponseInterface
    {
        return $this->basicRequest('GET', "vector_stores/$vectorStoreId/files");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function retrieveVectorStoreFile(string $vectorStoreId, string $fileId): ResponseInterface
    {
        return $this->basicRequest('GET', "vector_stores/$vectorStoreId/files/$fileId");
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function deleteVectorStoreFile(string $vectorStoreId, string $fileId): ResponseInterface
    {
        return $this->basicRequest('DELETE', "vector_stores/$vectorStoreId/files/$fileId");
    }

    ///< VECTOR STORE FILES


    ///> VECTOR STORE FILE BATCHES

    // POST https://api.openai.com/v1/vector_stores/{vector_store_id}/file_batches
    public function createVectorStoreFileBatch(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/vector_stores/{vector_store_id}/file_batches/{batch_id}
    public function retrieveVectorStoreFileBatch(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/vector_stores/{vector_store_id}/file_batches/{batch_id}/cancel
    public function cancelVectorStoreFileBatch(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/vector_stores/{vector_store_id}/file_batches/{batch_id}/files
    public function listVectorStoreFilesInBatch(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< VECTOR STORE FILE BATCHES


    ///> INVITES

    // GET https://api.openai.com/v1/organization/invites
    public function listInvites(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/invites
    public function createInvite(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/organization/invites/{invite_id}
    public function retrieveInvite(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // DELETE https://api.openai.com/v1/organization/invites/{invite_id}
    public function deleteInvite(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< INVITES


    ///> USERS

    // GET https://api.openai.com/v1/organization/users
    public function listUsers(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/users/{user_id}
    public function modifyUser(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/organization/users/{user_id}
    public function retrieveUser(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // DELETE https://api.openai.com/v1/organization/users/{user_id}
    public function deleteUser(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< USERS


    ///> PROJECTS

    // GET https://api.openai.com/v1/organization/projects
    public function listProjects(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/projects
    public function createProject(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/organization/projects/{project_id}
    public function retrieveProject(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/projects/{project_id}
    public function modifyProject(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/projects/{project_id}/archive
    public function archiveProject(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< PROJECTS


    ///> PROJECT USERS

    // GET https://api.openai.com/v1/organization/projects/{project_id}/users
    public function listProjectUsers(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/projects/{project_id}/users
    public function createProjectUser(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/organization/projects/{project_id}/users/{user_id}
    public function retrieveProjectUser(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/projects/{project_id}/users/{user_id}
    public function modifyProjectUser(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // DELETE https://api.openai.com/v1/organization/projects/{project_id}/users/{user_id}
    public function deleteProjectUser(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< PROJECT USERS


    ///> PROJECT SERVICE ACCOUNTS

    // GET https://api.openai.com/v1/organization/projects/{project_id}/service_accounts
    public function listProjectServiceAccounts(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // POST https://api.openai.com/v1/organization/projects/{project_id}/service_accounts
    public function createProjectServiceAccount(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/organization/projects/{project_id}/service_accounts/{service_account_id}
    public function retrieveProjectServiceAccount(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // DELETE https://api.openai.com/v1/organization/projects/{project_id}/service_accounts/{service_account_id}
    public function deleteProjectServiceAccount(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< PROJECT SERVICE ACCOUNTS


    ///> PROJECT API KEYS

    // GET https://api.openai.com/v1/organization/projects/{project_id}/api_keys
    public function listProjectApiKeys(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/organization/projects/{project_id}/api_keys/{key_id}
    public function retrieveProjectApiKey(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // DELETE https://api.openai.com/v1/organization/projects/{project_id}/api_keys/{key_id}
    public function deleteProjectApiKey(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< PROJECT API KEYS


    ///> AUDIT LOGS

    // GET https://api.openai.com/v1/organization/audit_logs
    public function listAuditLogs(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< AUDIT LOGS
}
