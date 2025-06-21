export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).send({ message: 'Only POST allowed' });
  }

  const { query } = req.body;

  if (!query) {
    return res.status(400).send({ message: 'Missing query' });
  }

  const webhookUrl = 'https://discord.com/api/webhooks/1386093430333247628/Axvh0ZxfJ2z7xKnG8bptxykUVF4-otaiDGTu88OCBVbusQ2wmpziG1NAodbXkT8G1SdV';
  const payload = {
    embeds: [
      {
        title: 'New Query',
        description: query,
        color: 0x00ff00,
      },
    ],
  };

  try {
    const response = await fetch(webhookUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(payload)
    });

    if (!response.ok) {
      throw new Error(`Discord responded with ${response.status}`);
    }

    res.status(200).json({ message: 'Sent!' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
}
