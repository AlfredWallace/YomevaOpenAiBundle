<?php

namespace Yomeva\OpenAiBundle\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Yomeva\OpenAiBundle\Builder\SerializerBuilder;
use Yomeva\OpenAiBundle\Exception\NotImplementedException;
use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;
use Yomeva\OpenAiBundle\Model\Assistant\ModifyAssistantPayload;
use Yomeva\OpenAiBundle\Model\File\FilePurpose;
use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Model\Message\ModifyMessagePayload;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\Run\CreateRunPayload;
use Yomeva\OpenAiBundle\Model\Run\CreateThreadAndRunPayload;
use Yomeva\OpenAiBundle\Model\Run\ModifyRunPayload;
use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;
use Yomeva\OpenAiBundle\Model\Thread\ModifyThreadPayload;

/**
 * This service is the entry point of the bundle. You should inject it wherever you need, and use functions to
 * make calls to the OpenAI APIs, thanks to the api_key you provided in the configuration.
 */
class OpenAiClient
{
    private HttpClientInterface $httpClient;
    private ValidatorInterface $validator;
    private Serializer $serializer;

    /**
     * This client initializes :
     * - a Symfony HTTP client with basic headers needed by the OpenAI APIs and ths OpenAI base URI as default
     * - a Symfony Validator
     * - a Symfony Serializer initialized with a dedicated configuration (check the SerializerBuilder)
     *
     * An OpenAI API key. This should ideally come from an ENV VAR.
     * @param string $openAiApiKey
     */
    public function __construct(
        private readonly string $openAiApiKey,
        bool $beta
    ) {
        $options = (new HttpOptions())
            ->setBaseUri('https://api.openai.com/v1/')
            ->setHeader('Content-Type', 'application/json')
            ->setHeader('Authorization', "Bearer {$this->openAiApiKey}");

        if ($beta) {
            $options->setHeader('OpenAI-Beta', 'assistants=v2');
        }

        $this->httpClient = HttpClient::create()->withOptions($options->toArray());

        $this->validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();

        $this->serializer = (new SerializerBuilder())->makeSerializer();
    }

    /**
     *
     * The HTTP method sent to the OpenAI APIs
     * @param string $method
     *
     * The URI part appended to the base OpenAI URI
     * @param string $url
     *
     * The payload, or body, sent to the OpenAI APIs.
     * If the payload is of type PayloadInterface, then it will be validated and normalized before being sent.
     * If it's an array, it's sent directly without any check.
     * @param PayloadInterface|array<string, mixed>|null $payload
     *
     * This response is directly returned from the Symfony HTTP client without any modification.
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     * @throws ExceptionInterface
     */
    private function request(
        string $method,
        string $url,
        PayloadInterface|array|null $payload = null
    ): ResponseInterface {
        if ($payload instanceof PayloadInterface) {
            $violations = $this->validator->validate($payload);

            if (count($violations) > 0) {
                throw new ValidationFailedException($payload, $violations);
            }

            $normalizedPayload = $this->serializer->normalize($payload);

            return $this->httpClient->request($method, $url, ['json' => $normalizedPayload]);
        } elseif (is_array($payload) && !empty($payload)) {
            return $this->httpClient->request($method, $url, ['json' => $payload]);
        } else {
            return $this->httpClient->request($method, $url);
        }
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
    public function uploadFile(FilePurpose $purpose, UploadedFile $uploadedFile): ResponseInterface
    {
        $handle = fopen($uploadedFile->getRealPath(), 'r');
        stream_context_set_option($handle, 'http', 'filename', $uploadedFile->getClientOriginalName());

        return $this->httpClient->request(
            'POST',
            'files',
            [
                'body' => [
                    'purpose' => $purpose->value,
                    'file' => $handle,
                ]
            ]
        );
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function listFiles(): ResponseInterface
    {
        return $this->request('GET', 'files');
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function retrieveFile(string $fileId): ResponseInterface
    {
        return $this->request('GET', "files/$fileId");
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function deleteFile(string $fileId): ResponseInterface
    {
        return $this->request('DELETE', "files/$fileId");
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
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function listModels(): ResponseInterface
    {
        return $this->request('GET', 'models');
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
     * @param array<string, mixed>|CreateAssistantPayload $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function createAssistant(array|CreateAssistantPayload $payload): ResponseInterface
    {
        return $this->request('POST', 'assistants', $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function listAssistants(): ResponseInterface
    {
        return $this->request('GET', 'assistants');
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function retrieveAssistant(string $assistantId): ResponseInterface
    {
        return $this->request('GET', "assistants/$assistantId");
    }

    /**
     * @param array<string, mixed>|ModifyAssistantPayload $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function modifyAssistant(string $assistantId, array|ModifyAssistantPayload $payload): ResponseInterface
    {
        return $this->request('POST', "assistants/$assistantId", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function deleteAssistant(string $assistantId): ResponseInterface
    {
        return $this->request('DELETE', "assistants/$assistantId");
    }

    ///< ASSISTANT


    ///> THREADS

    /**
     * @param array<string, mixed>|CreateThreadPayload $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function createThread(array|CreateThreadPayload $payload): ResponseInterface
    {
        return $this->request('POST', 'threads', $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function retrieveThread(string $threadId): ResponseInterface
    {
        return $this->request('GET', "threads/$threadId");
    }

    /**
     * @param array<string, mixed>|ModifyThreadPayload $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function modifyThread(string $threadId, array|ModifyThreadPayload $payload): ResponseInterface
    {
        return $this->request('POST', "threads/$threadId", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function deleteThread(string $threadId): ResponseInterface
    {
        return $this->request('DELETE', "threads/$threadId");
    }

    ///< THREADS


    ///> MESSAGES

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function createMessage(string $threadId, CreateMessagePayload $payload): ResponseInterface
    {
        return $this->request('POST', "threads/$threadId/messages", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function listMessages(string $threadId): ResponseInterface
    {
        return $this->request('GET', "threads/$threadId/messages");
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function retrieveMessage(string $threadId, string $messageId): ResponseInterface
    {
        return $this->request('GET', "threads/$threadId/messages/$messageId");
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function modifyMessage(string $threadId, string $messageId, ModifyMessagePayload $payload): ResponseInterface
    {
        return $this->request('POST', "threads/$threadId/messages/$messageId", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function deleteMessage(string $threadId, string $messageId): ResponseInterface
    {
        return $this->request('DELETE', "threads/$threadId/messages/$messageId");
    }

    ///< MESSAGES


    ///> RUNS

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function createRun(string $threadId, CreateRunPayload $payload): ResponseInterface
    {
        return $this->request('POST', "threads/$threadId/runs", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function createThreadAndRun(CreateThreadAndRunPayload $payload): ResponseInterface
    {
        return $this->request('POST', 'threads/runs', $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function listRuns(string $threadId): ResponseInterface
    {
        return $this->request('GET', "threads/$threadId/runs");
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function retrieveRun(string $threadId, string $runId): ResponseInterface
    {
        return $this->request('GET', "threads/$threadId/runs/$runId");
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function modifyRun(string $threadId, string $runId, ModifyRunPayload $payload): ResponseInterface
    {
        return $this->request('POST', "threads/$threadId/runs/$runId", $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function submitToolsOutputsToRun(string $threadId, string $runId, array $payload): ResponseInterface
    {
        return $this->request('POST', "threads/$threadId/runs/$runId/submit_tool_outputs", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function cancelRun(string $threadId, string $runId): ResponseInterface
    {
        return $this->request('POST', "threads/$threadId/runs/$runId/cancel");
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
     * @param array<string, mixed> $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function createVectorStore(array $payload = []): ResponseInterface
    {
        return $this->request('POST', 'vector_stores', $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function listVectorStores(): ResponseInterface
    {
        return $this->request('GET', 'vector_stores');
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function retrieveVectorStore(string $vectorStoreId): ResponseInterface
    {
        return $this->request('GET', "vector_stores/$vectorStoreId");
    }

    /**
     * @param array<string, mixed> $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function modifyVectorStore(string $vectorStoreId, array $payload = []): ResponseInterface
    {
        return $this->request('POST', "vector_stores/$vectorStoreId", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function deleteVectorStore(string $vectorStoreId): ResponseInterface
    {
        return $this->request('DELETE', "vector_stores/$vectorStoreId");
    }

    ///< VECTOR STORES


    ///> VECTOR STORE FILES

    /**
     * @param array<string, mixed> $payload
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function createVectorStoreFile(string $vectorStoreId, array $payload): ResponseInterface
    {
        return $this->request('POST', "vector_stores/$vectorStoreId/files", $payload);
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function listVectorStoresFiles(string $vectorStoreId): ResponseInterface
    {
        return $this->request('GET', "vector_stores/$vectorStoreId/files");
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function retrieveVectorStoreFile(string $vectorStoreId, string $fileId): ResponseInterface
    {
        return $this->request('GET', "vector_stores/$vectorStoreId/files/$fileId");
    }

    /**
     * @throws TransportExceptionInterface|ExceptionInterface
     */
    public function deleteVectorStoreFile(string $vectorStoreId, string $fileId): ResponseInterface
    {
        return $this->request('DELETE', "vector_stores/$vectorStoreId/files/$fileId");
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
