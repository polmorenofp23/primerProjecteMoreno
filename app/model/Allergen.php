<?php

class Allergen{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private ?int $id_allergen = null;
    
    /** VARCHAR(80) NOT NULL */
    private string $name;
    
    /** VARCHAR(255) NULL */
    private ?string $description = null;
    
    /** JSON NOT NULL - can be string (JSON) or array (decoded) */
    private array $icon_dir;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_allergen = isset($data['id_allergen']) ? (int)$data['id_allergen'] : null;
            $this->name = (string)($data['name'] ?? '');
            $this->description = isset($data['description']) ? (string)$data['description'] : null;
            $this->icon_dir = isset($data['icon_dir']) ? (is_string($data['icon_dir']) ? json_decode($data['icon_dir'], true) : $data['icon_dir']) : [];
        }
    }

    public function getId()
    {
        return $this->id_allergen;
    }
    public function setId($id)
    {
        $this->id_allergen = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getIconDir()
    {
        return $this->icon_dir;
    }
    public function setIconDir($icon_dir)
    {
        $this->icon_dir = $icon_dir;
        return $this;
    }

    public function getIconUrl(string $key = 'color', string $fallbackFolder = '/assets/img/icons/contain_allergen/')
    {
        $icons = $this->getIconDir() ?? [];
        $iconSrc = $icons[$key] ?? null;
        if (!$iconSrc || $iconSrc == '') return null;

        $url = (strpos($iconSrc, '/') === 0) ? $iconSrc : rtrim($fallbackFolder, '/') . '/' . ltrim($iconSrc, '/');
        $fs = rtrim((string)$_SERVER['DOCUMENT_ROOT'], '\/') . $url;
        return file_exists($fs) ? $url : null;
    }

    public function renderIconOrName(string $key = 'color', $attrs = 'width="40" height="40"')
    {
        $url = $this->getIconUrl($key);
        if ($url) {
            return '<img src="'.htmlspecialchars($url).'" alt="'.htmlspecialchars($this->getName()).': ' . htmlspecialchars($this->getDescription()) . '"
                title="'.htmlspecialchars($this->getName()).': ' . htmlspecialchars($this->getDescription()) . '" '.$attrs.' class="allergen-icon bg-transparent border-0">';
        }
        return '<span class="font-sting-regular fs-16 text-primary-dark-red text-uppercase">' . htmlspecialchars($this->getName() ?: 'Allergen') . '</span>';
    }
}