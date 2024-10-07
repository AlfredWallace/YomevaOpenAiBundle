<?php

namespace Yomeva\OpenAiBundle\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Yomeva\OpenAiBundle\Exception\NotImplementedException;

class OpenAiClient
{
    private HttpClientInterface $client;

    public function __construct(private readonly string $openAiApiKey)
    {
        $this->client = HttpClient::create(
            defaultOptions: [
                'base_uri' => 'https://api.openai.com/v1/',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $this->openAiApiKey",
                ]
            ]
        );
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

    // POST https://api.openai.com/v1/files
    public function uploadFile(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/files
    public function listFiles(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // GET https://api.openai.com/v1/files/{file_id}
    public function retrieveFile(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    // DELETE https://api.openai.com/v1/files/{file_id}
    public function deleteFile(): ResponseInterface
    {
        throw new NotImplementedException();
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
        return $this->client->request('GET', 'models');
    }

    ///< MODELS
}