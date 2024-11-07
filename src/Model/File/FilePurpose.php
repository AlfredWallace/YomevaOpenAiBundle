<?php

namespace Yomeva\OpenAiBundle\Model\File;

enum FilePurpose: string
{
    case Assistants = 'assistants';
    case Vision = 'vision';
    case Batch = 'batch';
    case FineTune = 'fine-tune';
}
