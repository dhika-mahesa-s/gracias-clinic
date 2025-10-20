<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Treatment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TreatmentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_renders_with_treatments()
    {
        Treatment::factory()->count(2)->create();

        $res = $this->get(route('treatments.index'));
        $res->assertStatus(200)
            ->assertViewIs('treatments.index')
            ->assertSee('Treatment Kami');
    }

    /** @test */
    public function manage_renders()
    {
        $res = $this->get(route('treatments.manage'));
        $res->assertStatus(200)->assertViewIs('treatments.manage');
    }

    /** @test */
    public function create_form_renders()
    {
        $res = $this->get(route('treatments.create'));
        $res->assertStatus(200)->assertViewIs('treatments.create');
    }

    /** @test */
    public function edit_form_renders()
    {
        $t = Treatment::factory()->create();
        $res = $this->get(route('treatments.edit', $t));
        $res->assertStatus(200)->assertViewIs('treatments.edit');
    }

    /** @test */
    public function show_page_renders()
    {
        $t = Treatment::factory()->create(['name' => 'Laser Rejuvenation']);
        $res = $this->get(route('treatments.show', $t));
        $res->assertStatus(200)
            ->assertViewIs('treatments.show')
            ->assertSee('Laser Rejuvenation');
    }

    /** @test */
    public function store_validates_required_fields()
    {
        $res = $this->post(route('treatments.store'), []);
        $res->assertSessionHasErrors(['name','description','price','duration','image']);
    }

    /** @test */
    public function store_saves_treatment_and_uploads_image()
    {
        Storage::fake('public');

        $payload = [
            'name'        => 'Facial Premium',
            'description' => 'Treatment wajah premium',
            'price'       => 200000, // will be stored as 200000.00
            'duration'    => 60,
            'image'       => UploadedFile::fake()->image('photo.jpg', 600, 600),
        ];

        $res = $this->post(route('treatments.store'), $payload);
        $res->assertRedirect(route('treatments.manage'));

        $t = Treatment::first();
        $this->assertNotNull($t);
        $this->assertSame('Facial Premium', $t->name);
        $this->assertSame('200000.00', (string) $t->price);
        $this->assertSame(60, $t->duration);
        Storage::disk('public')->assertExists($t->image);
    }

    /** @test */
    public function update_validates_required_fields_when_missing()
    {
        $t = Treatment::factory()->create(['image' => 'treatments/dummy.jpg']);

        $res = $this->put(route('treatments.update', $t), []);
        $res->assertSessionHasErrors(['name','description','price','duration']);
    }

    /** @test */
    public function update_replaces_image_and_deletes_old_file()
    {
        Storage::fake('public');

        $oldPath = UploadedFile::fake()->image('old.jpg')->store('treatments', 'public');
        $t = Treatment::factory()->create([
            'name' => 'Old',
            'description' => 'Old desc',
            'price' => 100000.00,
            'duration' => 30,
            'image' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $res = $this->put(route('treatments.update', $t), [
            'name'        => 'New Name',
            'description' => 'New Desc',
            'price'       => 300000,
            'duration'    => 90,
            'image'       => UploadedFile::fake()->image('new.jpg', 500, 500),
        ]);

        $res->assertRedirect(route('treatments.manage'));

        $t->refresh();
        $this->assertSame('New Name', $t->name);
        $this->assertSame('300000.00', (string) $t->price);
        $this->assertSame(90, $t->duration);

        Storage::disk('public')->assertExists($t->image);
        Storage::disk('public')->assertMissing($oldPath);
    }

    /** @test */
    public function destroy_deletes_record_and_image()
    {
        Storage::fake('public');

        $path = UploadedFile::fake()->image('to-delete.jpg')->store('treatments', 'public');
        $t = Treatment::factory()->create(['image' => $path]);

        Storage::disk('public')->assertExists($path);

        $res = $this->delete(route('treatments.destroy', $t));
        $res->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('treatments', ['id' => $t->id]);
        Storage::disk('public')->assertMissing($path);
    }
}
