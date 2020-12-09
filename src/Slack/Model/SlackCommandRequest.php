<?php

declare(strict_types=1);

namespace App\Slack\Model;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
class SlackCommandRequest
{
    private string  $token;
    private string  $teamId;
    private string  $teamDomain;
    private string  $channelId;
    private string  $channelName;
    private string  $userId;
    private string  $username;
    private string  $command;
    private string  $text;
    private string  $responseUrl;
    private string  $triggerId;
    private string  $apiAppId;
    private ?string $enterpriseId;

    /**
     * @param string      $token
     * @param string      $teamId
     * @param string      $teamDomain
     * @param string      $channelId
     * @param string      $channelName
     * @param string      $userId
     * @param string      $username
     * @param string      $command
     * @param string      $text
     * @param string      $responseUrl
     * @param string      $triggerId
     * @param string      $apiAppId
     * @param string|null $enterpriseId
     */
    public function __construct(
        string $token,
        string $teamId,
        string $teamDomain,
        string $channelId,
        string $channelName,
        string $userId,
        string $username,
        string $command,
        string $text,
        string $responseUrl,
        string $triggerId,
        string $apiAppId,
        ?string $enterpriseId = null
    ) {
        $this->token        = $token;
        $this->teamId       = $teamId;
        $this->teamDomain   = $teamDomain;
        $this->channelId    = $channelId;
        $this->channelName  = $channelName;
        $this->userId       = $userId;
        $this->username     = $username;
        $this->command      = $command;
        $this->text         = $text;
        $this->responseUrl  = $responseUrl;
        $this->triggerId    = $triggerId;
        $this->apiAppId     = $apiAppId;
        $this->enterpriseId = $enterpriseId;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->request->get('token'),
            $request->request->get('team_id'),
            $request->request->get('team_domain'),
            $request->request->get('channel_id'),
            $request->request->get('channel_name'),
            $request->request->get('user_id'),
            $request->request->get('user_name'),
            $request->request->get('command'),
            $request->request->get('text'),
            $request->request->get('response_url'),
            $request->request->get('trigger_id'),
            $request->request->get('api_app_id'),
            $request->request->get('enterprise_id')
        );
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getTeamId(): string
    {
        return $this->teamId;
    }

    /**
     * @return string
     */
    public function getTeamDomain(): string
    {
        return $this->teamDomain;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @return string
     */
    public function getChannelName(): string
    {
        return $this->channelName;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    /**
     * @return string
     */
    public function getTriggerId(): string
    {
        return $this->triggerId;
    }

    /**
     * @return string
     */
    public function getApiAppId(): string
    {
        return $this->apiAppId;
    }

    /**
     * @return string|null
     */
    public function getEnterpriseId(): ?string
    {
        return $this->enterpriseId;
    }
}
